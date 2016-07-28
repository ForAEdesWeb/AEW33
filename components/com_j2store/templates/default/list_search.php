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
defined('_JEXEC') or die( 'Restricted access' );
?>
<!--  Search block -->

		<div class="j2store-filter-product-search">
			<!-- Search Form starts here -->
				<!--  search Input box -->

					<div class="input-prepend input-append">
						<!-- Input text for entering search data -->
						<input type="text" name="search" id="search" value="<?php echo htmlspecialchars($this->lists['search']);?>"
							class="input j2store-product-search-textbox" style="width:<?php echo $this->layoutparams->get('product_list_filter_search_width', 140); ?>px;" onchange="document.adminForm.submit();" />
						<!-- Search Go Button -->
						<button class="btn btn-default" onclick="this.form.submit();">
							<?php echo JText::_( 'J2STORE_FILTER_GO' ); ?>
						</button>
						<!-- Search Reset Button -->
						<button class="btn btn-inverse" onclick="document.getElementById('search').value='';this.form.submit();">
							<i class="icon-remove glyphicon glyphicon-remove"></i>
						</button>
					</div>
		 </div>