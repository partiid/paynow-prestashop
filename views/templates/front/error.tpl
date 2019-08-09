{*
* NOTICE OF LICENSE
*
* This source file is subject to the MIT License (MIT)
* that is bundled with this package in the file LICENSE.md.
*
* @copyright mBank S.A.
* @license   MIT License
*}
{capture name=path}{l s='Pay by online transfer or BLIK' mod='paynow'}{/capture}

<div class="clearfix">
    <h2 class="amount-info">
        {l s='Pay for your order' mod='paynow'}:
        <strong>{$total_to_pay|escape:'htmlall':'UTF-8'}</strong>
    </h2>
</div>

<div class="alert alert-warning">
    {l s='An error occurred while processing your payment.' mod='paynow'}
</div>

<p class="cart_navigation clearfix" id="cart_navigation">
    <a class="button btn btn-default button-medium" href="{$button_action|escape:'htmlall':'UTF-8'}">
        <span>{l s='Retry payment with Paynow' mod='paynow'}<i class="icon-chevron-right right"></i></span>
    </a>
</p>
