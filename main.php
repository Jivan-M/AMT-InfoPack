<?php
/**
 * DokuWiki Dark Wood Template
 * Based on the starter template
 *
 * @link     http://dokuwiki.org/template:darkwood
 * @author   desbest <afaninthehouse@gmail.com>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
@require_once(dirname(__FILE__).'/tpl_functions.php'); /* include hook for template functions */
header('X-UA-Compatible: IE=edge,chrome=1');

$showTools = !tpl_getConf('hideTools') || ( tpl_getConf('hideTools') && !empty($_SERVER['REMOTE_USER']) );
$showSidebar = page_findnearest($conf['sidebar']) && ($ACT=='show');
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang'] ?>"
  lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>" class="no-js">
<head>
    <meta charset="UTF-8" />
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <?php tpl_metaheaders() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_includeFile('meta.html') ?>
    <script defer type="text/javascript" src="<?php echo tpl_basedir();?>/responsive.js"></script>
</head>

<body class=" <?php echo tpl_classes(); ?> <?php echo ($showSidebar) ? 'hasSidebar' : ''; ?>">


<!--[if IE]>  <div id="IEroot">  <![endif]--> 
<div id="dokuwiki__top" class="headercontainer">
<?php tpl_includeFile('header.html') ?>
<div class="header">


    <div class="headerpadding">
    
    <img src="<?php echo tpl_basedir();?>/images/logo.png" width="40" height="40" align="left"  style="margin-right: 1em;"/>
    <?php tpl_link(wl(),$conf['title'],'accesskey="h" title="[H]"') ?>

    <?php if ($conf['tagline']): ?>
        <p class="claim"><?php echo $conf['tagline'] ?></p>
    <?php endif ?>

    <ul class="a11y skip">
        <li><a href="#dokuwiki__content"><?php echo $lang['skip_to_content'] ?></a></li>
    </ul>
    <?php /* how to insert logo instead (if no CSS image replacement technique is used):
    upload your logo into the data/media folder (root of the media manager) and replace 'logo.png' accordingly:
    tpl_link(wl(),'<img src="'.ml('logo.png').'" alt="'.$conf['title'].'" />','id="dokuwiki__top" accesskey="h" title="[H]"') */ ?>
    </div></div>
    <div class="headerbridge"></div>
</div>
<!--[if IE]>  </div>  <![endif]-->

<!--[if IE]>  <div id="IEroot">  <![endif]--> 
<div class="container"><div class="allboxessameheight">

    <?php html_msgarea() /* occasional error and info messages on top of the page */ ?>

    <!-- BREADCRUMBS -->
    <?php if($conf['breadcrumbs']){ ?>
        <div class="breadcrumbs"><?php tpl_breadcrumbs() ?></div>
    <?php } ?>
    <?php if($conf['youarehere']){ ?>
        <div class="breadcrumbs"><?php tpl_youarehere() ?></div>
    <?php } ?>

<div class="left">
    


   <!-- ********** ASIDE ********** -->
    <?php if ($showSidebar): ?>
        <div id="writtensidebar"><!-- <div class="pad aside include group"> -->
            <?php tpl_includeFile('sidebarheader.html') ?>
            <?php tpl_include_page($conf['sidebar'], 1, 1) /* includes the nearest sidebar page */ ?>
            <?php tpl_includeFile('sidebarfooter.html') ?>
            <div class="clearer"></div>
        <!-- </div> --></div><!-- /aside -->
    <?php endif; ?>

    <div class="sideheader">Site Tools</div>
    <div class="sidebox">
        <div id="navcontainer">
            <ul id="navlist">
             <!-- SITE TOOLS -->
            <h3 class="a11y"><?php echo $lang['site_tools'] ?></h3>
            <?php tpl_searchform() ?>
            <ul>
                <?php tpl_toolsevent('sitetools', array(
                    'recent'    => tpl_action('recent', 1, 'li', 1),
                    'media'     => tpl_action('media', 1, 'li', 1),
                    'index'     => tpl_action('index', 1, 'li', 1),
                )); ?>
            </ul>
        </div>
        <br/>
    </div>

         


    <?php if ($showTools): ?>
    <div class="sideheader">Page Tools</div>
    <div class="sidebox">
        <div id="navcontainer">
            <h3 class="a11y"><?php echo $lang['page_tools'] ?></h3>
            <ul id="navlist">
             <!-- PAGE ACTIONS -->
            <?php tpl_toolsevent('pagetools', array(
                'edit'      => tpl_action('edit', 1, 'li', 1),
                'discussion'=> _tpl_action('discussion', 1, 'li', 1),
                'revisions' => tpl_action('revisions', 1, 'li', 1),
                'backlink'  => tpl_action('backlink', 1, 'li', 1),
                'subscribe' => tpl_action('subscribe', 1, 'li', 1),
                'revert'    => tpl_action('revert', 1, 'li', 1),
                'top'       => tpl_action('top', 1, 'li', 1),
            )); ?>
            </ul>
        </div>
        <br/>
    </div>
    <?php endif; ?>

    <?php if ($conf['useacl'] && $showTools): ?>
    <div class="sideheader">User Tools</div>
    <div class="sidebox">
        <h3 class="a11y"><?php echo $lang['user_tools'] ?></h3>
        <div id="navcontainer">
            <?php
                if (!empty($_SERVER['REMOTE_USER'])) {
                    echo '<p class="user">';
                    tpl_userinfo(); /* 'Logged in as ...' */
                    echo '</p>';
                }
            ?>
            <ul id="navlist">
               <!-- USER TOOLS -->
                
                <?php /* the optional second parameter of tpl_action() switches between a link and a button,
                         e.g. a button inside a <li> would be: tpl_action('edit', 0, 'li') */
                ?>
                <?php tpl_toolsevent('usertools', array(
                    'admin'     => tpl_action('admin', 1, 'li', 1),
                    'userpage'  => _tpl_action('userpage', 1, 'li', 1),
                    'profile'   => tpl_action('profile', 1, 'li', 1),
                    'register'  => tpl_action('register', 1, 'li', 1),
                    'login'     => tpl_action('login', 1, 'li', 1),
                )); ?>
            </ul>
        </div>
        <br/>
    </div>
    <?php endif ?>
</div>

<div class="middle">
    <div class="middleheader"><div>Home Page</div></div>
    
    
        <div class="middlebox">
            <!-- ********** CONTENT ********** -->
            <div id="dokuwiki__content"><div class="pad">
                <?php tpl_flush() /* flush the output buffer */ ?>
                <?php tpl_includeFile('pageheader.html') ?>

                <div class="page">
                    <!-- wikipage start -->
                    <?php tpl_content() /* the main content */ ?>
                    <!-- wikipage stop -->
                    <div class="clearer"></div>
                </div>

                <?php tpl_flush() ?>
                <?php tpl_includeFile('pagefooter.html') ?>
            </div></div><!-- /content -->
    </div>

</div>

     <!-- width is 250px -->
    <!-- <div class="right">
        <div class="sideheader"><div>Sidebar 2</div></div>
        <div class="sidebox">
        <p>Text here</p><br/>  
        </div>
    </div> -->
    
</div> <!-- close the allboxessameheight -->

<div class="footer">
    <a href="http://desbest.com" target="_blank">Dark Wood theme copyright desbest</a>
    <div class="doc"><?php tpl_pageinfo() /* 'Last modified' etc */ ?></div>
    <?php tpl_license('button') /* content license, parameters: img=*badge|button|0, imgonly=*0|1, return=*0|1 */ ?>
</div>
<?php tpl_includeFile('footer.html') ?>
<div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
</div> <!-- close the container -->


<!--[if IE]>  </div>  <![endif]-->

    <?php /* with these Conditional Comments you can better address IE issues in CSS files,
             precede CSS rules by #IE8 for IE8 (div closes at the bottom) */ ?>
    <!--[if lte IE 8 ]><div id="IE8"><![endif]-->

    <?php /* the "dokuwiki__top" id is needed somewhere at the top, because that's where the "back to top" button/link links to */ ?>
    <?php /* tpl_classes() provides useful CSS classes; if you choose not to use it, the 'dokuwiki' class at least
             should always be in one of the surrounding elements (e.g. plugins and templates depend on it) */ ?>
    <!-- this has to be at the bottom of the 
        page due to the way dokuwiki renders javascript -->
  
</body>
</html>
