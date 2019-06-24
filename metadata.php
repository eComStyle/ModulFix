<?php
/*
 *   *********************************************************************************************
 *      Please retain this copyright header in all versions of the software.
 *      Bitte belassen Sie diesen Copyright-Header in allen Versionen der Software.
 *
 *      Copyright (C) Josef A. Puckl | eComStyle.de
 *      All rights reserved - Alle Rechte vorbehalten
 *
 *      This commercial product must be properly licensed before being used!
 *      Please contact info@ecomstyle.de for more information.
 *
 *      Dieses kommerzielle Produkt muss vor der Verwendung ordnungsgemäß lizenziert werden!
 *      Bitte kontaktieren Sie info@ecomstyle.de für weitere Informationen.
 *   *********************************************************************************************
 */

$sMetadataVersion = '2.0';
$aModule = array(
    'id'                    => 'ecs_modulfix',
    'title'                 => '<strong style="color:#04B431;">e</strong><strong>ComStyle.de</strong>:  <i>ModulFix</i>',
    'description'           => 'Hilft, wenn Module nicht installiert werden koennen.',
    'version'               => '1.0.0',
    'thumbnail'             => 'ecs.png',
    'author'                => '<strong style="font-size: 17px;color:#04B431;">e</strong><strong style="font-size: 16px;">ComStyle.de</strong>',
    'email'                 => 'support@ecomstyle.de',
    'devmail'               => 'dev@ecomstyle.de',
    'url'                   => 'https://ecomstyle.de',
    'extend' => array(
        \OxidEsales\Eshop\Application\Controller\Admin\ModuleMain::class => \Ecs\ModulFix\Controller\Admin\ModuleMain::class,
    ),
    'events' => array(
        'onActivate'   => '\Ecs\ModulFix\Core\Events::onActivate',
        'onDeactivate' => '\Ecs\ModulFix\Core\Events::onDeactivate',
    ),
 );
