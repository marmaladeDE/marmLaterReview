<?php
/**
 * marmalade GmbH
 * OXID module to send our the request for reviews after the customer got his order.
 *
 * PHP version 5
 *
 * @author   Joscha Krug <support@marmalade.de>
 * @license  MIT License http://www.opensource.org/licenses/mit-license.html
 * @version  2.0
 * @link     https://github.com/marmaladeDE/marmLaterReview
 */

/**
 * Metadata version
 */
$sMetadataVersion = '1.1';

$aModule = array(
    'id'          => 'marm/laterreview',
    'title'       => 'marmalade :: later Review',
    'description' => array(
        'de'    => 'Senden Sie die Aufforderung erst nachdem der Kunde seine Bestellung bekommen hat.',
        'en'    => 'Send out our the request for reviews after the customer got his order.',
    ),
    'email'         => 'support@marmalade.de',
    'url'           => 'http://www.marmalade.de',
    'thumbnail'     => 'marmalade.jpg',
    'version'       => '2.0',
    'author'        => 'marmalade GmbH :: Joscha Krug / Jens Richter',
    'extend'    => array(
        'oxemail' => 'marm/laterreview/core/marm_laterreview_oxemail'
    ),
    'templates' => array(
         'marm_email_order_review_shop.tpl'         => 'marm/laterreview/views/admin/email/html/marm_email_order_review_shop.tpl',
         'marm_email_order_review_ts.tpl'           => 'marm/laterreview/views/admin/email/html/marm_email_order_review_ts.tpl',
         'marm_email_order_review_shop_plain.tpl'   => 'marm/laterreview/views/admin/email/plain/marm_email_order_review_shop_plain.tpl',
         'marm_email_order_review_ts_plain.tpl'     => 'marm/laterreview/views/admin/email/plain/marm_email_order_review_ts_plain.tpl',
    ),
    'settings'  => array(
        array(
                'group' => 'main',
                'name'  => 'blDebugMode',
                'type'  => 'bool',
        ),
        array(
                'group' => 'main',
                'name'  => 'iCount',
                'type'  => 'str',
                'value' => '20'
        ),
        array(
                'group' => 'main',
                'name'  => 'iStartWithOrder',
                'type'  => 'str',
                'value' => ''
        ),
        array(
                'group' => 'main',
                'name'  => 'iDelay',
                'type'  => 'str',
                'value' => '3'
        ),
        array(
                'group' => 'main',
                'name'  => 'sToken',
                'type'  => 'str',
                'value' => md5(rand(1,10))
        ),
        array(
                'group'      => 'main',
                'name'       => 'sMode',
                'type'       => 'select',
                'value'      => 'shopbewertung',
                'constrains' => 'shopbewertung|trustedshop|random'
        ),
        array(
                'group' => 'main',
                'name'  => 'sSubject',
                'type'  => 'str',
                'value' => 'Ihre Meinung ist uns wichtig.'
        ),
    )
);