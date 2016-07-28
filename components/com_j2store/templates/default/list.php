<?php
/*------------------------------------------------------------------------
 # com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Priya bose - Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2012 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/
/** Check to ensure this file is included in Joomla! */
defined('_JEXEC') or die( 'Restricted access' );
$doc = JFactory::getDocument();
$doc->addStyleSheet(JUri::root().'media/j2store/css/font-awesome.min.css');
$doc->addStyleSheet(JURI::root(true).'/media/j2store/css/j2store-product.css');
require_once (JPATH_SITE.'/components/com_j2store/helpers/utilities.php');
require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/library/j2item.php');
$action = JRoute::_('index.php');
$image_path = JUri::root();
//registered users check
$allow = true;
if($this->params->get('isregister', 0) && !JFactory::getUser()->id) {
//user not logged in. set to false
$allow = false;
}
?>

<style type="text/css" >
.j2store-item-productlist-thumbimage{
	width : <?php echo (int) $this->layoutparams->get('product_list_thumb_image_width', '100'); ?>px;
}
.j2store-item-cart-button{
	background:<?php echo $this->layoutparams->get('add_to_cartbtn_background_color', '#0055B3');?>;
	color:<?php echo $this->layoutparams->get('add_to_cartbtn_text_color', '#fff'); ?>;
}
</style>
<div class="j2store j2store-productlist-view">
	<div class="row">
		<?php
		//set span class as 12 in case modules are disabled
		$class  = "span12 col-md-12 col-lg-12 col-sm-12 col-xs-12"; ?>
		<!-- Check any one of the module in the position is published if published then the span size will be altered --->
			<?php if(
				$this->layoutparams->get('show_product_list_filter_category', 0)
				|| $this->layoutparams->get('show_product_list_filter_price', 0)
				|| $this->layoutparams->get('show_product_list_filter_tag', 0)
			):?>
			<?php $class="span9 col-md-9 col-lg-9 col-sm-9 col-xs-12"; ?>
			<div class="span3 col-md-3 col-lg-3 col-sm-3 col-xs-12">
				<!-- Load the modules partial tempalte -->
				<?php  echo $this->loadTemplate('modules');?>
			</div>
		<?php endif;?>

		<div class="<?php echo $class;?>">
		    <div class="row">
                <form action="<?php echo $action; ?>" method="post" name="adminForm"  id="adminForm">
                    <?php if($this->layoutparams->get('show_product_list_filter_selection', 1)): ?>
                        <?php if(isset($this->lists['category_title'])
                            || isset($this->lists['search'])
                            || isset($this->lists['search'])
                            || isset($this->lists['filter_price_from'])
                            || isset($this->lists['filter_price_to'])
                            || isset($this->lists['filter_tag_title'])
                            || count(JModuleHelper::getModule('j2store_module_sorting'))
                        ): ?>
                            <!--  Form Starts here again -->
                            <div class="j2store-filters-selection">
                                <!-- List showing the filter type used to search the product -->
                                <ul class="j2store-filter-lists">
                                    <?php if(!empty($this->lists['category_title'])) : ?>
                                        <!-- Based on the category this shows which product is currently choosed -->
                                        <li class="j2store-product-filter filter-categories">
                                            <?php echo JText::_('J2STORE_CATEGORIES');?><span> <?php echo ">" ;?> </span><?php echo $this->lists['category_title'];?>
                                        </li>
                                    <?php endif; ?>

                                    <?php if(isset($this->lists['search'])): ?>
                                        <!-- This shows what data have been entered in the filter  -->
                                        <li class="j2store-product-filter filter-search">
                                            <?php echo $this->lists['search'];?>
                                        </li>
                                    <?php endif; ?>

                                    <!-- this shows the price filters -->
                                    <?php if(isset($this->lists['filter_price_from']) || (isset($this->lists['filter_price_to']))):?>
                                        <li class="j2store-product-filter filter-price-range">
                                            <?php echo JText::_('J2STORE_PRICES');?>
                                            <?php echo J2StorePrices::number($this->lists['filter_price_from']);?>-<?php echo J2StorePrices::number($this->lists['filter_price_to']);?>
                                            <a class="j2store-product-reset-filter btn btn-inverse btn-mini" href="<?php echo JRoute::_("&filter_price_from=&filter_price_to=&rangeselected="); ?>">
                                                <i class="icon-remove glyphicon glyphicon-remove"></i>
                                            </a>
                                        </li>
                                    <?php endif;?>

                                    <!-- shows the selected tags -->
                                    <?php if(!empty( $this->lists['filter_tag'])):?>
                                        <li class="j2store-product-filter filter-tags"><?php echo JText::_('J2STORE_TAGS');?>	: <?php echo $this->lists['filter_tag_title'];?></li>
                                        <?php if(!empty($this->lists['filter_tag'])):?>
                                            <a class="j2store-product-reset-filter btn btn-inverse btn-mini" href="<?php echo JRoute::_("&filter_tag=&&filter_tag_title="); ?>">
                                                <i class="icon-remove glyphicon glyphicon-remove"></i>
                                            </a>
                                        <?php endif;?>
                                        </li>
                                    <?php endif;?>

                                </ul>
                            </div>

                            <!-- Sorting Module -->
                            <?php if($this->layoutparams->get('show_product_list_filter_sort', 0)): ?>
                                <?php
                                $attr	= array("class"=>"input mod-j2store-product-sorting","onchange"=>"this.form.submit()");
                                ?>
                                <div class="j2store-filter-sorting">
                                    <?php echo JHTML::_('select.genericlist', $this->filters['sort_fields'], 'filter_sort',$attr,'value','text',$this->lists['filter_sort']); ?>
                                </div>
                            <?php endif; ?>

                            <?php if($this->layoutparams->get('show_product_list_filter_search', 0)): ?>
                                <?php echo $this->loadTemplate('search'); ?>
                            <?php endif; ?>

                        <?php endif; ?>
                    <?php endif; ?>
                    <input type="hidden" name="option" value="com_j2store" />
                    <input type="hidden" name="view" value="products" />
                    <input type="hidden" name="task" value="list" />
                    <input type="hidden" name="list_limit" value="<?php echo $this->list_limit;?>" />
                    <?php echo JHTML::_( 'form.token' ); ?>
                </form>
		    </div>

            <!-- Products -->
            <?php if(isset($this->items) && $this->items):?>
                <?php
                $total = count($this->items);
                $col = $this->layoutparams->get('list_no_of_columns', 1);
                $counter = 0;
                ?>
                <?php foreach($this->items as $item): ?>

                    <?php $rowcount = ((int) $counter % (int) $col) + 1; ?>
                    <?php if ($rowcount == 1) : ?>
                        <?php $row = $counter / $col; ?>
                        <div class="j2store-products-row cols-<?php echo (int) $col;?> <?php echo 'row-'.$row; ?> row">
                    <?php endif; ?>
                    <div class="span<?php echo round((12 / $col));?> col-sm-<?php echo round((12 / $col));?>">
                        <div class="j2store-product-single j2store-product-single-<?php echo $item->product_id; ?> column-<?php echo $rowcount;?>"
                            itemscope itemtype="http://schema.org/Product">
                            <?php
                            $this->item = &$item;
                            echo $this->loadTemplate('item');
                            ?>
                        </div><!-- end item -->
                        <?php $counter++; ?>
                    </div><!-- end span -->
                    <?php if (($rowcount == $col) or ($counter == $total)) : ?>
                        </div><!-- end row -->
                    <?php endif; ?>

                <?php endforeach;?>
            <?php else:?>
                <div class="alert alert-warning">
                    <?php echo JText::_('J2STORE_PRODUCT_NO_ITEMS_TO_DISPLAY');?>
                </div>
            <?php endif;?>

		</div>
	</div>


	<!-- Footer Starts Here -->
	<div class="j2store-product-footer row">
		<div class="span12 col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<!-- Fotter Starts here -->

					<form action="<?php echo $action; ?>" method="post" name="adminForm"  id="adminForm" enctype="multipart/form-data">
						<?php echo $this->pagination->getListFooter(); ?>
					<input type="hidden" name="option" value="com_j2store" />
					<input type="hidden" name="view" value="products" />
					<input type="hidden" name="task" value="list" />
					<input type="hidden" name="list_limit" value="<?php echo $this->list_limit;?>" />
					<?php echo JHTML::_( 'form.token' ); ?>
				</form>
		</div>
	</div>

</div>


<script type="text/javascript">
/** Add to Cart Button text   **/
var layoutCartText ='<?php echo $this->layoutparams->get('product_list_addtocart_alternative_text', JText::_('J2STORE_ADD_TO_CART')); ?>';
var redirect=<?php echo $this->layoutparams->get('show_product_list_options', 1); ?>;
(function($) {
	$(document).ready(function(){
		$('.j2storeProductForm').each(function(){
			$(this).submit(function(e) {
				e.preventDefault();
				var form = $(this);
				/* Get input values from form */
				var values = form.serializeArray();
			$.ajax({
				url: 'index.php',
				type: 'post',
				data: values,
				dataType: 'json',
				beforeSend: function() {
					form.find("#addtoCartBtn").attr('value','<?php echo JText::_('J2STORE_PRODUCT_ITEM_ADDING_TO_CART');?>');
				},
				success: function(json) {
					form.find('.j2success, .j2warning, .j2attention, .j2information, .j2error').remove();
					$('.j2store-notification').hide();
					if (json['error']) {
						if (json['error']['stock']) {
							form.find('.j2stock').after('<span class="j2error">' + json['error']['stock'] + '</span>');
						}
						if (json['error']['product']) {
							form.find('.j2product').after('<span class="j2error">' + json['error']['product'] + '</span>');
						}
						if (json['error']['option']) {
							//check wheather layout enables option
							//if show product option is diabled and having error then else statement will be executed
							if(redirect){
								for (i in json['error']['option']) {
									form.find('#option-' + i).after('<span class="j2error">' + json['error']['option'][i] + '</span>');
								}
							}else{
								//will redirect to detailed page
								window.location = json['redirect'];
							}
				}
			}
			//just ot display success msg
			if (json['success']) {
				doMiniCart();
				form.find("#addtoCartBtn").attr('value','<?php echo JText::_('J2STORE_PRODUCT_ITEM_ADDED');?>');
				$(".checkout-link").hide();
				form.find(".checkout-link").show();
				}
			},
			complete:function (){
					form.find("#addtoCartBtn").attr('value',layoutCartText);
		    	 }
				});
			});
		});
	});
})(j2store.jQuery);
</script>