<?php
class Config {
    public static $dataPath = '/var/bablo/data/';
    static $dbuser = 'bablo3';
    static $dbpass = 'parol';
    static $dbhost = 'localhost';
    static $dbname = 'bablo';
    
    static $authRequiredActions = [
        'income/*',
        'expence/*',
        'currency/*',
        'user/logout',
        'user/showUser',
    ];
}

