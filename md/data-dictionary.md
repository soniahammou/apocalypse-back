## User

|Field|Type|Specificity|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|Unique identification of the user|
|email|VARCHAR(150)|NOT NULL|User email|
|firstname|VARCHAR(64)|NOT NULL|User firstname|
|lastname|VARCHAR(64)|NOT NULL|User lastname|
|password|VARCHAR(255)|NOT NULL|User password|
|role|VARCHAR(64)|NOT NULL|User role|

## Article

|Field|Type|Specificity|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|Unique identification of the article|
|title|VARCHAR(255)|NOT NULL||
|summary|VARCHAR(255)|NOT NULL|short summary of the article|
|content|TEXT|NOT NULL||
|slug|VARCHAR(255)|NOT NULL|short url|
|picture||VARCHAR(255)|NULL|Url for a picture illustrating the article (not mandatory)|
|created_at|TIMESTAMP|NOT NULL, CURRENT_TIMESTAMP||
|updated_at|TIMESTAMP|NULL, CURRENT_TIMESTAMP||
|category_id|INT|NOT NULL, UNSIGNED|Foreign key to link the category chosen for the article|
|status_id|INT|NOT NULL, UNSIGNED|Foreign key to link  the status of the article (pending, validated, rejected)|
|user_id|INT|NULL, UNSIGNED|Foreign key to link the author (could be null so the article is not purged if the user deletes their account)|

## Category

|Field|Type|Specificity|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|Unique identification of the category|
|name|VARCHAR(64)|NOT NULL||
|home_order|TINYINT(2)|NOT NULL, UNSIGNED, DEFAULT 0|Defined if a category will appear on the home page|

## Status

|Field|Type|Specificity|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|Unique identification of the status|
|name|VARCHAR(64)|NOT NULL||

## Question

|Field|Type|Specificity|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|Unique identification of the question|
|title|VARCHAR(255)|NOT NULL||
|content|TEXT|NOT NULL||
|created_at|TIMESTAMP|NOT NULL, CURRENT_TIMESTAMP||
|updated_at|TIMESTAMP|NULL, CURRENT_TIMESTAMP||
|user_id|INT|NULL, UNSIGNED|Foreign key to link the asker (could be null so the question is not purged if the user deletes their account)|

## Answer

|Field|Type|Specificity|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|Unique identification of the question|
|content|TEXT|NOT NULL||
|created_at|TIMESTAMP|NOT NULL, CURRENT_TIMESTAMP||
|updated_at|TIMESTAMP|NULL, CURRENT_TIMESTAMP||
|user_id|INT|NULL, UNSIGNED|Foreign key to link the answerer (could be null so the answer is not purged if the user deletes their account)|
|question_id|INT|NOT NULL, UNSIGNED|Foreign key to link the question answered (can't be null so the answer is purged if the question is deleted)|

## Pinpoint

|Field|Type|Specificity|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|Unique identification of the pinpoint|
|latitude|FLOAT(6)|NOT NULL|GPS coordinates : latitude with a precision of 6 decimals|
|longitude|FLOAT(6)|NOT NULL|GPS coordinates : longitude with a precision of 6 decimals|
|description|TEXT|NOT NULL|Short description of the nature of the pinpoint ("very ugly looking zombie, do not approach" / "old well with more or less clean water (it's the apocalypse, don't be picky!)" / "totally legal drugs (all the cops are zombies anyway)" / ...) |
|created_at|TIMESTAMP|NOT NULL, CURRENT_TIMESTAMP||
|updated_at|TIMESTAMP|NULL, CURRENT_TIMESTAMP||
|user_id|INT|NULL, UNSIGNED|Foreign key to link the pinpointer (could be null so the pin is not removed from teh map if the user deletes their account)|
|type_id|INT|NOT NULL, UNSIGNED|Foreign key to link the type of point (can't be null so the point is removed if the type no longer exists)|

## Type

|Field|Type|Specificity|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|Unique identification of the type of point|
|name|VARCHAR(64)|NOT NULL||
|icon_url|VARCHAR(255)|NOT NULL|URL of the icon illustrating the type on the map|

## Search Notice

|Field|Type|Specificity|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|Unique identification of the search notice|
|firstname|VARCHAR(64)|NOT NULL|Firstname of the seeked out person|
|lastname|VARCHAR(64)|NOT NULL|Lastname of the seeked out person|
|description|TEXT|NOT NULL|Description of the seeked out person|
|age|TINYINT(3)|NULL|Age of the seeked out person (might be replaced by an age range)|
|picture|VARCHAR(255)|NULL|Url for a picture of the seeked out person (not mandatory)|
|status|TINYINT(1)|NOT NULL, DEFAULT 0|0 = search ongoing / 1 = found|
|created_at|TIMESTAMP|NOT NULL, CURRENT_TIMESTAMP||
|updated_at|TIMESTAMP|NULL, CURRENT_TIMESTAMP||
|user_id|INT|NOT NULL, UNSIGNED|Foreign key to link the searcher (can't be null so the search notice is removed if the user deletes their account)|

## City

|Field|Type|Specificity|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|Unique identification of the city|
|name|VARCHAR(255)|NOT NULL||
|number_views|INT|NOT NULL, DEFAULT 0|Counter of the number of times one person had been seen in a particular city|
|created_at|TIMESTAMP|NOT NULL, CURRENT_TIMESTAMP||
|updated_at|TIMESTAMP|NULL, CURRENT_TIMESTAMP||

## search_notice_city

|Field|Type|Specificity|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|Unique identification of the cross table item|
|city_id|INT|NOT NULL, UNSIGNED|Foreign key to link the cities where the person had been seen|
|search_notice_id|INT|NOT NULL, UNSIGNED|Foreign key to link the search notice of one particular person|
