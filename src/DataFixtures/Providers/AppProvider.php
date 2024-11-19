<?php

namespace App\DataFixtures\Providers;


class AppProvider
{
    private $catgeorieName = [
        'Protection',
        'Divers',
        'Equipement',
        'Santé',
        'Cuisine',
        'Construction',
        'Zombies'
    ];
  

    private $statusName = [
        'en attente',
        'refusé',
        'validé',
    ];

    private $articleContent = [
        "Évitez de Devenir un Buffet à Zombies : Guide d'un Abri Sûr" => "
            Dans un monde où les morts-vivants errent sans relâche, un abri sûr peut faire toute la différence entre la survie et devenir un déjeuner pour zombies. Suivez ce guide pour construire un abri qui vous protégera des hordes affamées et vous permettra de garder votre humanité intacte.
    
            Choix de l'Emplacement
            - Recherchez un endroit éloigné des zones urbaines et densément peuplées.
            - Choisissez un site surélevé pour éviter les inondations et avoir une meilleure visibilité.
    
            Matériaux de Construction
            - Utilisez des matériaux solides et durables comme des cartons renforcés et des palettes en bois.
            - Renforcez les murs avec du ruban adhésif résistant et des bâches plastiques pour une meilleure isolation.
    
            Équipement de Survie
            - Stockez des provisions non périssables, de l'eau potable et des outils de survie essentiels.
            - Prévoyez une source d'énergie alternative comme des générateurs solaires ou des piles rechargeables.
    
            Sécurité et Défense
            - Installez des systèmes d'alarme pour détecter les intrusions de zombies.
            - Prévoyez des armes improvisées comme des battes de baseball ou des objets contondants pour vous défendre en cas d'attaque.
    
            Astuces Finale
            - Restez discret et évitez d'attirer l'attention des zombies avec du bruit ou des lumières vives.
            - Faites régulièrement des exercices d'évacuation pour être prêt à quitter l'abri en cas d'urgence.
    
            En suivant ces conseils, vous augmenterez vos chances de survie dans un monde infesté de zombies. Restez vigilant et rappelez-vous : un abri bien construit peut être votre meilleur allié dans la lutte contre les morts-vivants.
        ",
        "Transforme Tes Vieilles Casseroles en Armure Fashion" => "
            Bienvenue dans l’univers fabuleux de la mode apocalyptique, où chaque casserole et poêle peut devenir une pièce essentielle de ton équipement de survie. Prépare-toi à impressionner les zombies (et peut-être à survivre) avec ton look unique et fonctionnel !
    
            Matériaux Farfelus Mais Efficaces
            - Vieilles Casseroles et Poêles : Les nouvelles armures en acier des temps modernes. En plus, elles font un bruit d'enfer pour effrayer les zombies.
            - Ceintures en Cuir : Utilisées pour tout attacher et donner ce petit côté rebelle.
            - Couvercles de Poubelles : Tes nouveaux boucliers de héros. Adieu les frisbees, bonjour la protection ultime.
            - Ruban Adhésif (l'arme secrète) : Parce que tout tient avec du scotch, même tes rêves.
    
            Étapes de Création Loufoques
            1. Protection des Bras et Jambes : 
               - Enroule des ceintures et du ruban adhésif autour de tes membres. La mode apocalypse, c’est serré et sécurisé !
               - Fixe des morceaux de vieilles casseroles sur les parties stratégiques. Pour le style, bien sûr.
    
            2. Plastron et Dos :
               - Prends un vieux pull (le plus moche que tu trouves).
               - Attache des couvercles de poubelles sur le devant et le dos avec des ceintures et du ruban adhésif. Tu seras invincible et chic.
    
            3. Casque et Gants :
               - Utilise un vieux pot de fleurs ou un saladier comme casque. Glamour et protection en un seul accessoire.
               - Mets des gants de jardinage et renforce-les avec du ruban adhésif. Tes mains resteront belles et entières.
    
            Astuces Délirantes
            - Personnalise Ton Style : Plus c'est bizarre, mieux c'est ! Les zombies seront trop perplexes pour t'attaquer.
            - Camouflage Fashion : Peins ton armure avec des motifs ridicules pour distraire les zombies. Avec un peu de chance, ils seront morts de rire.
            - Réparations Express : Garde toujours du ruban adhésif à portée de main. C'est comme du scotch magique pour ton armure.
    
            En suivant ces étapes, tu seras prêt à affronter les zombies avec une armure qui ne passe pas inaperçue. Reste créatif et souviens-toi : l’humour et le style sont tes meilleures armes contre la fin du monde (et les zombies).
        ",
        "Survivre avec Style : Accessoires Incontournables" => "
            Qui a dit que l'apocalypse devait compromettre votre sens du style ? Dans ce guide, nous vous présentons les accessoires indispensables pour survivre à l'apocalypse zombie tout en restant élégant et bien dans votre peau.
    
            Lunettes de Soleil Anti-Zombie
            - Protégez vos yeux du soleil... et des regards menaçants des morts-vivants avec une paire de lunettes de soleil teintées.
            - Choisissez un modèle résistant aux chocs pour une protection supplémentaire en cas d'attaque surprise.
    
            Sac à Dos Multifonctionnel
            - Optez pour un sac à dos solide et spacieux pour transporter vos provisions, votre équipement de survie et bien sûr, votre nécessaire de beauté.
            - Recherchez des compartiments spéciaux pour garder vos affaires organisées, même dans les situations les plus chaotiques.
    
            Bandana Anti-Poussière (et Anti-Zombie)
            - Un bandana est l'accessoire parfait pour protéger votre visage de la poussière, du vent... et des morsures de zombie.
            - Choisissez un motif qui reflète votre personnalité et votre détermination à survivre avec style.
    
            Bottes de Survie Élégantes
            - Ne sous-estimez pas l'importance de bonnes chaussures en période d'apocalypse. Optez pour des bottes robustes et confortables qui vous permettront de parcourir des kilomètres sans souci.
            - Recherchez des modèles qui combinent fonctionnalité et esthétique pour un look qui en impose.
    
            Montre Imperméable Indestructible
            - Une montre fiable est essentielle pour rester à l'heure, même lorsque le monde s'effondre autour de vous.
            - Choisissez un modèle étanche et résistant aux chocs pour une durabilité maximale pendant vos aventures post-apocalyptiques.
    
            Avec ces accessoires incontournables, vous serez prêt à affronter les défis de l'apocalypse zombie avec style et assurance. Alors n'ayez pas peur de montrer au monde que vous pouvez survivre avec panache !
        ",
        "Les Zombies et Toi : Coexistence ou Pas" => "
            Face à l'apocalypse zombie, la question se pose : est-il possible de coexister pacifiquement avec les morts-vivants, ou sommes-nous condamnés à un affrontement sans fin ? Dans cet article, nous explorons les différentes perspectives sur cette épineuse question.
    
            Approche de la Coexistence
            - Certains survivants prônent une approche pacifique, cherchant à comprendre les motivations des zombies et à trouver des moyens de vivre en harmonie avec eux.
            - Des initiatives telles que des zones de sécurité partagées et des programmes de réhabilitation zombie ont été proposées pour favoriser la cohabitation.
    
            Stratégies de Défense
            - D'autres considèrent les zombies comme une menace inévitable et préconisent des mesures de défense agressives pour garantir la sécurité des communautés humaines.
            - Des techniques de combat avancées et des barricades renforcées sont mises en place pour repousser les attaques de zombies et protéger les zones habitées.
    
            Évolution des Relations
            - Alors que certaines interactions entre humains et zombies restent tendues, des cas isolés de coopération ont été signalés, suggérant une possible évolution des relations entre les deux espèces.
            - Des initiatives de sensibilisation et d'éducation sont en cours pour promouvoir la compréhension mutuelle et la tolérance dans un monde post-apocalyptique.
    
            Conclusion
            - La question de la coexistence avec les zombies reste complexe et sujette à débat. Alors que certains restent optimistes quant à la possibilité d'une paix durable, d'autres continuent de se préparer à un conflit inévitable.
            - Quelle que soit votre opinion sur la question, une chose est sûre : dans un monde envahi par les morts-vivants, la survie reste la priorité absolue.
    
            En fin de compte, la décision de coexister ou de combattre les zombies dépendra de vos valeurs, de vos convictions et de votre instinct de survie. Choisissez avec sagesse, car votre décision pourrait façonner le destin de l'humanité dans ce nouveau monde.
        ",
        "Construis un Abri Anti-Zombie avec des Cartons" => "
            Dans un monde envahi par les morts-vivants, la construction d'un abri sûr est essentielle pour assurer votre survie. Dans cet article, nous vous montrons comment utiliser des matériaux simples tels que des cartons pour créer un abri anti-zombie efficace et fonctionnel.
    
            Choix de l'Emplacement
            - Recherchez un endroit éloigné des zones urbaines et densément peuplées pour réduire les risques d'attaque zombie.
            - Optez pour un site surélevé et facilement défendable pour une protection supplémentaire contre les hordes de zombies.
    
            Préparation des Matériaux
            - Rassemblez des cartons robustes et résistants à l'eau pour la construction de votre abri.
            - Démontez les cartons et aplatissez-les pour en faire des panneaux de construction plus facilement manipulables.
    
            Assemblage de l'Abri
            1. Fondation :
               - Disposez les panneaux de carton sur le sol pour créer une base solide pour votre abri.
               - Utilisez du ruban adhésif ou de la colle pour fixer les panneaux ensemble et renforcer la structure.
    
            2. Murs et Toit :
               - Érigez les panneaux de carton pour former les murs de votre abri, en veillant à les fixer solidement les uns aux autres.
               - Utilisez des morceaux de carton supplémentaires pour créer un toit incliné, assurant ainsi une protection contre les intempéries et les attaques aériennes de zombies.
    
            3. Porte et Fenêtres :
               - Découpez soigneusement des ouvertures pour la porte et les fenêtres, en vous assurant qu'elles sont assez grandes pour permettre une entrée facile tout en conservant une sécurité maximale.
               - Utilisez du ruban adhésif pour renforcer les bords des ouvertures et ajouter des morceaux de carton supplémentaires pour plus de solidité.
    
            Finitions et Décoration
            - Ajoutez des couches supplémentaires de carton pour renforcer les zones vulnérables de votre abri, telles que les coins et les jonctions.
            - Personnalisez votre abri avec des dessins et des motifs pour le rendre plus accueillant et dissuader les zombies de s'approcher.
    
            En suivant ces étapes simples, vous pourrez construire un abri anti-zombie résistant et sécurisé à partir de matériaux facilement disponibles. Préparez-vous à affronter l'apocalypse avec confiance, car avec un abri solide, vous êtes mieux armé pour survivre aux défis qui vous attendent.
        ",
        "Survie pour les Nuls : Éviter de Devenir un Apéritif" => "
            Vous êtes novice en matière de survie dans un monde infesté de zombies ? Pas de panique ! Dans cet article, nous vous proposons quelques conseils simples mais essentiels pour éviter de devenir la prochaine collation des morts-vivants.
    
            Restez en Mouvement
            - Évitez les endroits surpeuplés et les zones à risque élevé pour minimiser vos chances d'attirer l'attention des zombies.
            - Déplacez-vous discrètement et évitez les mouvements brusques qui pourraient vous trahir.
    
            Restez Silencieux
            - Limitez les bruits et les conversations inutiles pour ne pas attirer l'attention des zombies.
            - Utilisez des signaux gestuels ou des chuchotements pour communiquer avec les membres de votre groupe sans alerter les morts-vivants.
    
            Restez Caché
            - Trouvez des endroits sûrs et discrets pour vous cacher en cas d'urgence.
            - Utilisez la végétation dense, les bâtiments abandonnés ou les véhicules abandonnés comme abris temporaires pour échapper aux zombies.
    
            Restez Prêt
            - Gardez votre équipement de survie à portée de main en tout temps, y compris de la nourriture, de l'eau, des médicaments et des outils de défense.
            - Restez attentif à votre environnement et anticipez les dangers potentiels pour réagir rapidement en cas d'attaque de zombies.
    
            Restez Positif
            - Gardez espoir et restez concentré sur votre objectif de survie, même dans les situations les plus désespérées.
            - Rappelez-vous que même les plus grands héros ont commencé quelque part, et avec de la détermination et un peu de chance, vous pouvez survivre à cette apocalypse zombie.
    
            En suivant ces conseils simples mais cruciaux, même les débutants en survie peuvent augmenter leurs chances de survie dans un monde infesté de zombies. Alors n'ayez pas peur, restez prudent et préparez-vous à affronter les défis qui vous attendent avec courage et détermination.
        "
    ];


    private $questionName = [
        "Quelles sont les étapes essentielles pour se préparer à une apocalypse zombie ?",
        "Quelles armes sont les plus efficaces contre les zombies ?",
        "Quels sont les meilleurs abris anti-zombies et comment les sécuriser ?",
        "Comment s'assurer un approvisionnement suffisant en nourriture et en eau dans un monde envahi par les zombies ?",
        "Quelles stratégies de survie sont recommandées en milieu urbain pour éviter les hordes de zombies ?",
        "Comment soigner les blessures et les infections dans un contexte post-apocalyptique ?",
        "Quels sont les moyens de communication sécurisés dans un monde dévasté par une apocalypse zombie ?",
        "Quelles recettes de cuisine peuvent être préparées avec des ressources limitées en période post-apocalyptique ?",
        "Quelles techniques de camouflage sont efficaces pour éviter la détection par les zombies ?",
        "Comment maintenir un moral fort dans des circonstances désespérées ?",
        "Quels véhicules sont les plus sûrs pour fuir les zones infectées par les zombies ?",
        "Quelles compétences de survie sont indispensables pour chasser, piéger et se défendre dans un monde post-apocalyptique ?",
        "Comment former des alliances et construire des communautés dans un monde post-apocalyptique ?",
        "Quels dangers supplémentaires, en dehors des zombies, faut-il éviter dans un monde dévasté ?",
        "Quels sont les meilleurs conseils pour protéger et éduquer les enfants dans un monde post-apocalyptique ?",
        "Quand et comment est-il approprié d'utiliser la force contre les zombies ?",
        "Quels sont les meilleurs endroits pour se cacher et trouver un refuge sûr dans un monde dangereux ?",
        "Comment fabriquer des pièges et des barrières de défense contre les zombies avec des moyens DIY (fait maison) ?",
        "Comment fonctionne la nouvelle économie d'échange de ressources et de services dans un monde chaotique ?",
        "Quelles stratégies adopter pour reconstruire la civilisation après une apocalypse zombie ?"
    ];



    private $types = [
        'Arme' => 'https://cdn-icons-png.flaticon.com/128/427/427276.png',
        'Provision' => 'https://cdn-icons-png.flaticon.com/128/4417/4417832.png',
        'Soin' => 'https://cdn-icons-png.flaticon.com/128/7196/7196589.png',
        'Abri' => 'https://cdn-icons-png.flaticon.com/128/3010/3010995.png',
        'Danger' => 'https://cdn-icons-png.flaticon.com/128/1028/1028690.png',
        'Rassemblement' => 'https://cdn-icons-png.flaticon.com/128/1581/1581030.png',
        'Zombie' => 'https://cdn-icons-png.flaticon.com/128/1233/1233009.png',
        'Eau' => 'https://cdn-icons-png.flaticon.com/128/824/824239.png',
    ];

    private $descriptionSearchNotice = [
        [
            'prenom' => 'Julie',
            'nom' => 'Dubois',
            'age' => 30,
            'description' => "Elle est petite avec des cheveux longs et bruns, portant des lunettes et des boucles d'oreilles en forme de cœur. Elle a une cicatrice sur la joue gauche.",
            'ville' => 'Paris'
        ],
        [
            'prenom' => 'Jean',
            'nom' => 'Dupont',
            'age' => 40,
            'description' => "Grand et mince, avec des cheveux marron courts et des yeux marron foncé. Il porte une barbe bien entretenue et a une tatouage tribal sur son avant-bras gauche.",
            'ville' => 'Marseille'
        ],
        [
            'prenom' => 'Sophie',
            'nom' => 'Martin',
            'age' => 25,
            'description' => "De taille moyenne avec des cheveux roux bouclés et des taches de rousseur sur le visage. Elle porte un piercing au nez et un tatouage d'étoile sur le poignet droit.",
            'ville' => 'Lyon'
        ],
        [
            'prenom' => 'Thomas',
            'nom' => 'Lefebvre',
            'age' => 35,
            'description' => "Costaud avec des cheveux noirs courts et des yeux marrons perçants. Il a une cicatrice sur le front et des boucles d'oreilles en argent.",
            'ville' => 'Toulouse'
        ],
        [
            'prenom' => 'Marie',
            'nom' => 'Leroy',
            'age' => 40,
            'description' => "Grande et élancée avec des cheveux blonds platine coupés courts et des yeux bleus étincelants. Elle porte un collier en argent et une bague en forme de papillon.",
            'ville' => 'Nice'
        ],
        [
            'prenom' => 'Pierre',
            'nom' => 'Moreau',
            'age' => 50,
            'description' => "De stature moyenne avec des cheveux gris poivre et sel et une moustache soigneusement taillée. Il porte des lunettes et une chemise à carreaux.",
            'ville' => 'Bordeaux'
        ],
        [
            'prenom' => 'Caroline',
            'nom' => 'Girard',
            'age' => 30,
            'description' => "Petite avec des cheveux châtains ondulés et des yeux marrons. Elle porte un collier en perles et a un tatouage de fleur sur la cheville gauche.",
            'ville' => 'Lille'
        ],
        [
            'prenom' => 'Nicolas',
            'nom' => 'Andre',
            'age' => 45,
            'description' => "De grande taille avec des cheveux bruns désordonnés et une barbe de quelques jours. Il porte un piercing à l'oreille gauche et une montre en cuir.",
            'ville' => 'Strasbourg'
        ],
        [
            'prenom' => 'Camille',
            'nom' => 'Thomas',
            'age' => 35,
            'description' => "Elle est de taille moyenne avec des cheveux noirs raides et des lunettes rondes. Elle porte un chemisier à motifs floraux et un bracelet en argent.",
            'ville' => 'Nantes'
        ],
        [
            'prenom' => 'Vincent',
            'nom' => 'Petit',
            'age' => 40,
            'description' => "Costaud avec des cheveux blonds en brosse et des yeux bleu clair. Il a une cicatrice sur le menton et porte un piercing à la lèvre inférieure.",
            'ville' => 'Montpellier'
        ],
    ];
    
    private $city = [
        'Paris',
        'Marseille',
        'Lyon',
        'Toulouse',
        'Nice',
        'Bordeaux',
        'Lille',
        'Strasbourg',
        'Nantes',
        'Montpellier'
    ];

    private $report = [
        [
            'id' => 1,
            'count' => 5,
        ],
        [
            'id' => 2,
            'count' => 3,
        ],
        [
            'id' => 3,
            'count' => 2,
        ],
        [
            'id' => 4,
            'count' => 4,
        ],
        [
            'id' => 5,
            'count' => 6,
        ],
        [
            'id' => 6,
            'count' => 3,
        ],
        [
            'id' => 7,
            'count' => 1,

        ],
        [
            'id' => 8,
            'count' => 2,
        ],
        [
            'id' => 9,
            'count' => 4,
        ],
        [
            'id' => 10,
            'count' => 5,

        ],
    ];
    
    private $pinpointDescription = [
        [
            'description' => "Un bunker secret contenant des armes et des munitions. Accès restreint et bien gardé par un groupe de survivants. Idéal pour se réapprovisionner en cas de confrontation imminente avec les zombies ou d'autres dangers.",
            'longitude' => 2.3488,
            'latitude' => 48.8534,
        ],
        [
            'description' => "Un entrepôt sécurisé abritant des vivres essentielles : nourriture en conserve, eau et rations énergétiques. Contrôlé par une communauté locale qui échange des ressources contre des services ou des informations.",
            'longitude' => 4.8357,
            'latitude' => 45.7640,
        ],
        [
            'description' => "Un hôpital de campagne offrant des premiers soins et des médicaments de base. Personnel médical limité mais dévoué, traitant les blessures et infections mineures. Point de contact crucial pour les soins d'urgence.",
            'longitude' => 5.3698,
            'latitude' => 43.2965,
        ],
        [
            'description' => "Un refuge sécurisé avec des murs renforcés et des systèmes de défense improvisés. Capable d'accueillir plusieurs familles, équipé de lits, de couvertures et de chauffage. Surveillance constante pour prévenir les intrusions.",
            'longitude' => -1.6778,
            'latitude' => 48.1173,
        ],
        [
            'description' => "Une zone fortement infestée de zombies et d'autres menaces. Marquée par des panneaux d'avertissement et des barricades. À éviter sauf en cas d'extrême nécessité. Surveillance accrue recommandée pour passer en toute sécurité.",
            'longitude' => 7.2655,
            'latitude' => 43.7102,
        ],
        [
            'description' => "Un espace ouvert où les survivants se réunissent pour échanger des informations et des ressources. Activités de troc et de négociation fréquentes. Point de contact pour former des alliances et des communautés.",
            'longitude' => 1.4437,
            'latitude' => 43.6045,
        ],
        [
            'description' => "Un bâtiment abandonné mais sécurisé où des zombies ont été repérés. Danger potentiel élevé, à éviter. Évitez les zones proches et signalez tout mouvement suspect. Restez vigilant et soyez prêt à fuir en cas de besoin.",
            'longitude' => 4.3510,
            'latitude' => 50.8503,
        ],
        [
            'description' => "Une source d'eau potable fraîche située dans une zone protégée. Point de ravitaillement essentiel pour les groupes de survivants. Accès sécurisé et contrôlé pour éviter les contaminations.",
            'longitude' => 2.3522,
            'latitude' => 48.8566,
        ],
    ];
    
    
    // getters

    /**
     * Retourne un tableau de catgeorieName pour les fixtures
     *
     * @return array
     */
    public function getCategorieName(): array
    {
        return $this->catgeorieName;
    }

   /**
     * Retourne un tableau de statusName pour les fixtures
     *
     * @return array
     */
    public function getStatusName(): array
    {
        return $this->statusName;
    }


   /**
     * Retourne un tableau de statusName pour les fixtures
     *
     * @return array
     */
    public function getarticleContent(): array
    {
        return $this->articleContent;
    }
  
  

       /**
     * Retourne un tableau de catgeorieName pour les fixtures
     *
     * @return array
     */
    public function getQuestionName(): array
    {
        return $this->questionName;
    }

      /**
     * Retourne un tableau des types pour les fixtures
     *
     * @return array
     */
  public function types(): array
    {
        return $this->types;
    }



      /**
     * Retourne un tableau des types pour les fixtures
     *
     * @return array
     */
    public function getdescriptionSearchNotice(): array
    {
        return $this->descriptionSearchNotice;
    }

    /* Retourne un tableau des city pour les fixtures
    *
    * @return array
    */
   public function getcity(): array
   {
       return $this->city;
   }
 /* Retourne un tableau des report pour les fixtures
    *
    * @return array
    */
    public function getPinpointDescription(): array
    {
        return $this->pinpointDescription;
    }
  /* Retourne un tableau des description de pinpoint pour les fixtures
    *
    * @return array
    */
    public function getReport(): array
    {
        return $this->report;
    }
 

    // ! Liste de methodes de recuperation aléatoire de tableau
     /**
     * Retourne un nom aléatoire statusName pour les fixtures
     *
     * @return string
     */
    public function getOneRamdonStatusName(): string
    {
        return $this->statusName[array_rand($this->statusName)];
    }

     /**
     * Retourne un nom aléatoire statusName pour les fixtures
     *
     * @return string
     */
    public function getOneRamdonCategorieName(): string
    {
        return $this->catgeorieName[array_rand($this->catgeorieName)];
    }


     /**
     * Retourne un nom aléatoire statusName pour les fixtures
     *
     * @return string
     */
    public function getOneRamdonarticleContent(): array
    {
        $key = array_rand($this->articleContent);
        $value = $this->articleContent[$key];
        return [$key, $value];

    }


    /**
     * Retourne un nom aléatoire question pour les fixtures
     *
     * @return string
     */
    public function getOneRamdonQuestionName(): string
    {
        return $this->questionName[array_rand($this->questionName)];
    }


    public function typeRandom(): array
    {
        $key = array_rand($this->types);
        $value = $this->types[$key];
        return [$key, $value];
    }

   // ! Liste de methodes de recuperation cyclique de tableau
     /**
     * Retourne la valeur de l'index de statusName pour les fixtures
     *
     * @return string
     */
    public function getStatusNames(int $index): string
{
    return $this->statusName[$index];
}

public function getCategoriesNames(int $index): string
{
    return $this->catgeorieName[$index];
}

    
}