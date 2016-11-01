<?php

/**
 * QuickTemplate class for Cip skin
 * @ingroup Skins
 */
class CipTemplate extends BaseTemplate {
	/* Functions */

	private $userLoggedIn = false;
	private $isMainPage = false;

	/**
	 * Outputs the entire contents of the (X)HTML page
	 */
	public function execute() {
		// Build additional attributes for navigation urls
		$nav = $this->data['content_navigation'];
		$this->data['namespace_urls'] = $nav['namespaces'];
		$this->data['view_urls'] = $nav['views'];
		$this->data['action_urls'] = $nav['actions'];
		$this->data['variant_urls'] = $nav['variants'];

		$this->data['pageLanguage'] =
			$this->getSkin()->getTitle()->getPageViewLanguage()->getHtmlCode();

		// State flags
        $this->userLoggedIn = $this->getSkin()->getUser() && $this->getSkin()->getUser()->isLoggedIn();
        $this->isMainPage = $this->getSkin()->getTitle() && $this->getSkin()->getTitle()->isMainPage();

		// Output HTML Page
		$this->html( 'headelement' );

		//die(var_dump($this->data['view_urls']));
		?>

        <div class="container">

            <!-- Header -->
            <div class="cip-header">
                <div class="row cip-header-wrapper">
                    <!-- Logo -->
                    <div class="col-xs-1 cip-logo">
                        <a href="<?=Title::newMainPage()->getFullURL()?>">
                            <img src="<?=$this->getSkin()->getSkinStylePath('assets/img/logo.png')?>" />
                        </a>
                    </div>
                    <!-- Menu -->
                    <div class="col-md-6 col-sm-8 cip-menu">
                        <div class="cip-title"><a href="<?=Title::newMainPage()->getFullURL()?>">Climate Initiatives Platform</a></div>
                        <div class="cip-menu-items">
                            <ul>
                                <? foreach ($this->data['sidebar']['navigation'] as $sidebarKey => $sidebarContent): ?>
                                    <li>
                                        <? if( strpos($sidebarContent['text'], '|') !== false ): ?>
                                            <a data-toggle="tooltip" data-placement="bottom"
                                               title="<?=substr($sidebarContent['text'], strpos($sidebarContent['text'], '|')+1)?>"
                                               href="<?=$sidebarContent['href']?>">
                                                <?=substr($sidebarContent['text'], 0, strpos($sidebarContent['text'], '|'))?>
                                            </a>
                                        <? else: ?>
                                            <a href="<?=$sidebarContent['href']?>"><?=$sidebarContent['text']?></a>
                                        <? endif; ?>
                                    </li>
                                <? endforeach; ?>
                                <? if( $this->userLoggedIn ): ?>
                                <li>
                                    <a href="<?=Title::newFromText('Browse initiatives')->getFullURL()?>">
                                        Browse initiatives
                                    </a>
                                </li>
                                <li>
                                    <a href="<?=SpecialPage::getTitleFor('FormEdit')->getFullURL()?>/Climate_initiative/">
                                        Add Initiative
                                    </a>
                                </li>
                                <li class="cip-menu-item-no-border">
                                    <a href="<?=SpecialPage::getTitleFor('Logout')->getFullURL()?>">
                                        Log Out
                                    </a>
                                </li>
                                <li>
                                    Logged in as <b><?=$this->getSkin()->getUser()->getName()?></b>
                                </li>
                                <? else: ?>
                                <? if( $this->getSkin()->getUser()->isAllowed('createaccount') ): ?>
                                    <li class="cip-menu-item-no-border">
                                        <a href="#" data-toggle="tooltip"
                                           data-placement="bottom"
                                           title="Create a user-profile">
                                            Join
                                        </a>
                                    </li>
                                <? endif; ?>
                                <li class="cip-menu-item-no-border">
                                    <a href="<?=SpecialPage::getTitleFor('UserLogin')->getFullURL()?>" data-toggle="tooltip"
                                       data-placement="bottom"
                                       title="Login into the system">
                                        Log In
                                    </a>
                                </li>
                                <? endif; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- Pictures -->
                    <div class="col-md-5 col-sm-3 cip-pictures">
                        <div class="cip-header-funded">
                            Funded by the Dutch Ministry of Infrastructure and the Environment:
                        </div>
                        <ul>
                            <li>
                                <a href="#">
                                <img width="200" src="<?=$this->getSkin()->getSkinStylePath('assets/img/pic1.png')?>" />
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <img width="210" src="<?=$this->getSkin()->getSkinStylePath('assets/img/pic2.png')?>" />
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <? if($this->userLoggedIn): ?>
                <div class="row cip-actions-wrapper">
                    <div class="col-md-12 cip-actions-panel">
                        <ul class="float-xs-left">
	                        <? foreach ($this->data['view_urls'] as $key => $action): ?>
                                <?php echo $this->makeListItem( $key, $action ); ?>
	                        <? endforeach; ?>
                        </ul>
                        <ul class="float-sm-right">
                            <? foreach ($this->data['action_urls'] as $key => $action): ?>
                                <?php echo $this->makeListItem( $key, $action ); ?>
                            <? endforeach; ?>
                            <? if($this->getSkin()->getUser()->isAllowed('upload')): ?>
                                <li>
                                    <a href="<?=SpecialPage::getTitleFor('Upload')->getFullURL()?>">
                                        Upload
                                    </a>
                                </li>
                            <? endif; ?>
                        </ul>
                    </div>
                </div>
                <? endif; ?>
            </div>

            <!-- Content -->
            <div id="mw-page-base" class="noprint"></div>
            <div id="mw-head-base" class="noprint"></div>
            <div id="content" class="mw-body" role="main">
                <a id="top"></a>
                <div id="mw-js-message" style="display:none;"<?php $this->html( 'userlangattributes' ) ?>></div>
	            <?php if ( $this->data['sitenotice'] ): ?>
                    <!-- sitenotice -->
                    <div id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div>
                    <!-- /sitenotice -->
	            <?php endif; ?>

		        <?if (!$this->isMainPage): ?>
                    <!-- firstHeading -->
                    <h1 id="firstHeading" class="firstHeading" lang="<?php
                    $this->data['pageLanguage'] = $this->getSkin()->getTitle()->getPageViewLanguage()->getCode();
                    $this->html( 'pageLanguage' );
                    ?>"><span dir="auto"><?php $this->html( 'title' ) ?></span></h1>
                    <!-- /firstHeading -->
                <? endif; ?>

                <!-- bodyContent -->
                <div id="bodyContent">

                    <?if (!$this->isMainPage): ?>

                        <!--
                        <?php if ( $this->data['isarticle'] ): ?>
                            <div id="siteSub"><?php $this->msg( 'tagline' ) ?></div>
                        <?php endif; ?>
                        -->

                        <!-- subtitle -->
                        <div id="contentSub"<?php $this->html( 'userlangattributes' ) ?>><?php $this->html( 'subtitle' ) ?></div>
                        <!-- /subtitle -->

                        <?php if ( $this->data['undelete'] ): ?>
                            <!-- undelete -->
                            <div id="contentSub2"><?php $this->html( 'undelete' ) ?></div>
                            <!-- /undelete -->
                        <?php endif; ?>

                        <?php if( $this->data['newtalk'] ): ?>
                            <!-- newtalk -->
                            <div class="usermessage"><?php $this->html( 'newtalk' )  ?></div>
                            <!-- /newtalk -->
                        <?php endif; ?>

                    <? endif; ?>

                    <!-- bodycontent -->
	                <?php $this->html( 'bodycontent' ) ?>
                    <!-- /bodycontent -->

                    <?php if ( $this->data['printfooter'] ): ?>
                        <!-- printfooter -->
                        <div class="printfooter">
			                <?php $this->html( 'printfooter' ); ?>
                        </div>
                        <!-- /printfooter -->
	                <?php endif; ?>

	                <?php if ( $this->data['catlinks'] ): ?>
                        <!-- catlinks -->
		                <?php $this->html( 'catlinks' ); ?>
                        <!-- /catlinks -->
	                <?php endif; ?>

	                <?php if ( $this->data['dataAfterContent'] ): ?>
                        <!-- dataAfterContent -->
		                <?php $this->html( 'dataAfterContent' ); ?>
                        <!-- /dataAfterContent -->
	                <?php endif; ?>

                    <!-- debughtml -->
	                <?php $this->html( 'debughtml' ); ?>
                    <!-- /debughtml -->

                </div>
            </div>

            <!-- Footer -->
            <div class="row cip-footer">
                <div class="col-md-12">
	            <!--
                    <?php foreach( $this->getFooterLinks() as $category => $links ): ?>
                    <? if($category == 'info') { continue; } ?>
                    <ul id="footer-<?php echo $category ?>">
			            <?php foreach( $links as $link ): ?>
                            <li id="footer-<?php echo $category ?>-<?php echo $link ?>"><?php $this->html( $link ) ?></li>
			            <?php endforeach; ?>
                    </ul>
	            <?php endforeach; ?>
	            -->
                    <ul>
                        <li>
                            <a href="<?=Title::newFromText('General_disclaimer', NS_PROJECT)->getFullURL()?>">
                                Disclaimers
                            </a>
                        </li>
                        <? if( !$this->userLoggedIn ): ?>
                        <li>
                            <a href="<?=SpecialPage::getTitleFor('UserLogin')->getFullURL()?>">
                                Log In
                            </a>
                        </li>
                        <? endif; ?>
                    </ul>
                </div>
            </div>

        </div>

		<?php $this->printTrail(); ?>

		</body>
		</html>
		<?php
	}
}
