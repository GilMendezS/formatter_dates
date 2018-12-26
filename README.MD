## Formatter Class

Example usging the class

```php
    <?php
    use ..\Helpers\CustomFormatDate;
    $date_to_change_format = "01-ago-2018"
    $formatter = new CustomFormatDate($date_to_change_format);
    echo $formatter->getDateWithYMDFormat();
    // output: 2018-08-01
```
Or you can use the factory class:

```php
    use ..\Factories\DateFactory;
    $date_to_change_format = "01-ago-2018"
    echo DateFactory::createFormatYMDFrom($date_to_change_format);
    // output: 2018-08-01
```

* Y-m-d will be the format returned
