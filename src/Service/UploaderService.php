<?php


namespace App\Service;

use App\Entity\Article;
use App\Entity\SearchNotice;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UploaderService extends AbstractController
{


    /**
     * Verification de mimetype d'un fichier
     *
     * @param Request $request
     * @param [type] $object
     * @return void
     */
    public function uploadFile(Request $request, $object)
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('pictureFile');
        dump($file);

        if ($file instanceof UploadedFile && $file->isValid()) {
            $object->setPictureFile($file);
            dump($object->setPictureFile($file));
            
        }elseif (is_null($file)) {
            if ($object instanceof Article) {
                $category =  $object->getCategory();
                $this->setCategoriePicture($category, $object);
            }
            if ($object instanceof SearchNotice) {
                $object->setPicture($request->getSchemeAndHttpHost() . '/images/searchnotices/test-default-sn.png');
            }
        } 
        
        else {
            // Dans le cas d'un fichier invalide tel que le mimeType application/octet-stream
            // on accepte pas l'image et on retourne une erreur
            return $this->json([
                'success' => false,
                'errors' => "Fichier non supporté, merci d'importer un fichier valide",
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }


/**
 * Creation de l'url d'hebergement d'image qui sera flush en BDD après le persiste 
 *
 * @param [type] $request
 * @param [type] $object
 * @return void
 */
    public function uploadFileAfterPersit($request, $object, $path)
    {
        $file = $request->files->get('pictureFile');

        if (is_null($file)) {
            if ($object instanceof Article) {
                $category =  $object->getCategory();
                $this->setCategoriePicture($category, $object);
            }
            if ($object instanceof SearchNotice) {
                $object->setPicture($request->getSchemeAndHttpHost() . '/images/searchnotices/test-default-sn.png');
            }
        } else {
            $imageUrl = $request->getSchemeAndHttpHost() . '/images/' . $path . '/' . $object->getPicture();
            $object->setPicture($imageUrl);
        }
    }


 /**
     * Setter de l'image categorie sur l'objet dont il
     *
     * @param [type] $category
     * @param [type] $object
     * @return void
     */
    public function setCategoriePicture($category, $object){

        // si une categorie exite : setter l'image de l'objet courant avec l'image de la categorie
        if ($category) {
            $pictureCategory = $category->getPicture();
            $object->setPicture($pictureCategory);
        } else {
            // si une image n'existe pas, je sett l'image de l'objet courant à null
            $object->setPictureFile(null);
        }

    }



}
