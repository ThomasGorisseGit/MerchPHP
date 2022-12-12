# MerchPHP
Projet web en PHP dans le cadre de notre 2eme année de BUT Informatique

### Faire des recherches sur l'autoLoading

## TODO :
dans le controleur :
```php
if($connected){
    <?php ob_start() ?>
    <?= TODO ?>
    <?php $content = $ob_get_clean(); ?>
}
else{
    ...
}