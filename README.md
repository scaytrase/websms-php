[![Build Status](https://travis-ci.org/scaytrase/websms-php.svg?branch=master)](https://travis-ci.org/scaytrase/websms-php)
[![Latest Stable Version](https://poser.pugx.org/scaytrase/websms-php/v/stable)](https://packagist.org/packages/scaytrase/websms-php)
[![Latest Unstable Version](https://poser.pugx.org/scaytrase/websms-php/v/unstable)](https://packagist.org/packages/scaytrase/websms-php)
[![Total Downloads](https://poser.pugx.org/scaytrase/websms-php/downloads)](https://packagist.org/packages/scaytrase/websms-php)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/39774f8b-ef2b-4b6c-a675-1b4803d7f538/mini.png)](https://insight.sensiolabs.com/projects/39774f8b-ef2b-4b6c-a675-1b4803d7f538)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/scaytrase/websms-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/scaytrase/websms-php/?branch=master)

# WebSMS PHP Library

A tiny library for sending SMS via [WebSMS](http://websms.ru/) gateway. 
This gateway requires you to be registered in order to send SMS.

## Installation

The best way to handle dependencies is to use Composer

### Composer

```bash
    composer require "scaytrase/websms-php"
```

## Usage

```php
    $driver = new JsonDriver();
    $connection = new Connection($driver, 'username', 'secret');
    
    // Optionally check that connection runs well
    // $connection->verify(); 
    // echo $connection->getBalance(); 
    
    $message = new Message('+79991234567', 'test message');
    $connection->send($message);
```
