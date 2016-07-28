<?php
/*------------------------------------------------------------------------
# com_j2store - J2 Store
# ------------------------------------------------------------------------
# author    Ramesh Elamathi- Weblogicx India http://www.weblogicxindia.com
# copyright Copyright (C) 2014 - 19 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://j2store.org
# Technical Support:  Forum - http://j2store.org/forum/index.html
-------------------------------------------------------------------------*/
// No direct access
defined('_JEXEC') or die;

$links = $vars->links;
$doc = JFactory::getDocument();
$doc->addStyleSheet(JUri::root().'media/j2store/css/font-awesome.min.css');
require_once JPATH_ADMINISTRATOR.'/components/com_j2store/version.php';
$user = JFactory::getUser();
$isroot = $user->authorise('core.admin');
$update_yes = 0;
if($isroot) {
	$update = LiveUpdate::getUpdateInformation();
	if($update->hasUpdates) {
		$update_yes = 1;
		$update_version = $update->version;
		$update_url = 'index.php?option=com_j2store&view=liveupdate';
	}
}
?>
<?php if(!empty($links)): ?>
<!-- J2store Admin Sidebar Starts -->
<?php if(version_compare(JVERSION, '3.0', 'lt')):?>
<div class="j2store">
<div class="row-fluid">
<?php endif; ?>
<div id="j2store-submenu" class="j2store sidebar span3">

		<!-- User Panel Starts-->
			<div class="user-panel">
				<!-- J2store Logo -->
		            <div class="pull-left image">
		                 <img  src="<?php echo JURI::root();?>media/j2store/images/dashboard/dashboard-logo.png"  class="img-circle" alt="j2store logo" />
		            </div>
	            <!-- J2store Logo Ends -->

	            <!-- J2store Version Starts -->
	            <div class="info">
	                 <h3>
						v <?php echo $vars->manifest->version; ?>
						<?php if(J2STORE_PRO == 1): ?>
							<?php echo 'PRO'; ?>
						<?php else: ?>
							<?php echo 'CORE'; ?>
						<?php endif; ?>
					</h3>
				</div>
				<!-- J2store Version Ends -->

				<!-- Social Share Starts -->
				<div class="social-share">
					<div class="btn-group">
						<a class="btn btn-xs btn-primary" href="https://www.facebook.com/j2store" target="_blank">
							<i class="fa fa-facebook"></i>
						</a>
						<a class="btn btn-xs btn-primary" href="https://twitter.com/j2store_joomla" target="_blank">
							<i class="fa fa-twitter"></i>
						</a>
					</div>
				</div>
				<!-- Social Share Ends-->
				<?php if($update_yes) : ?>
					<div class="">
						<a class="btn btn-danger" href="<?php echo $update_url ?>"><?php echo JText::sprintf('J2STORE_UPDATE_TO_VERSION', $update_version); ?></a>
					</div>
				<?php endif; ?>
	        </div>
	      <!-- User panel Ends -->

          <!-- J2store Admin Navigation Starts-->
			<ul class="nav nav-list">

				<?php foreach($links as $link): ?>
				<?php $dropdown = false; ?>

				<?php
					if(array_key_exists('dropdown', $link)) {
						$dropdown = $link['dropdown'];
					}
				?>
				<?php	if($dropdown): ?>
						<?php $class = ($link['active'] ==1) ? ' active': 'dropdown'; ?>

						<li class="<?php echo $class; ?>" >
							<h4>
								<?php if($link['icon']): ?>
									<i class="icon <?php echo $link['icon']; ?>"></i>
								<?php endif; ?>
								<?php echo $link['name']; ?>

							</h4>

							<ul class="j2store-menu-children">
								<?php foreach($link['items'] as $item): ?>
									<?php
										$class = ($item["active"]==1) ? 'active' : '';
									?>

									<li	class="<?php echo $class; ?>">
										<?php if($item['icon']): ?>
											<i class="icon <?php echo $item['icon']; ?>"></i>
										<?php endif; ?>
										<?php if($item['link']): ?>
											<a tabindex="-1" href="<?php echo $item['link']; ?>"> <?php echo $item['name']; ?></a>
										<?php else: ?>
											<?php echo $item['name']; ?>
										<?php endif; ?>
									</li>

								<?php endforeach;?>
							</ul>

					<?php else: ?>
					<?php
						$class = ($link['active'] == 1)?'active':'';
					?>
						<li class="<?php echo $class; ?>" >
							<h3>
							<?php if($link['icon']): ?>
								<i class="icon <?php echo $link['icon']; ?>"></i>
							<?php endif; ?>

							<?php if($link['link']) : ?>
								<a href="<?php echo $link['link']; ?>"> <?php echo $link['name']; ?></a>
							<?php else: ?>
								<?php echo $link['name']; ?>
							<?php endif; ?>
							</h3>
						</li>
					<?php endif; ?>

				<?php endforeach; ?>
			</ul>
	      <!-- J2store Admin Navigation Ends-->

	      <!-- Copyrights Section Starts -->
			<div class="j2store-copyrights">
				<h3>Credits</h3>
				<div>
					<p>
						Copyright &copy;
						<?php echo date('Y');?>
						-
						<?php echo date('Y')+5; ?>
						Sasivarnakumar / <a href="http://www.j2store.org"><b><span
								style="color: #000; display: inline;">J2</span><span
								style="color: #666666; display: inline;">Store</span> </b>.org</a>
					</p>
					<p>
						If you use J2Store, please post a rating and a review at the <a
							target="_blank"
							href="http://extensions.joomla.org/extensions/e-commerce/shopping-cart/19687">Joomla!
							Extensions Directory</a>.
					</p>
				</div>
			 </div>
		 <!-- Copyrights Section Ends -->

</div>
<!-- J2store Admin Sidebar Ends -->
<?php endif; ?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#j2store-submenu").nextAll(".j2store").attr("class", 'j2store span9');
	});
</script>