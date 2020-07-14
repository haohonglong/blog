<?php

/* @var $this \yii\web\View */
/* @var $content string */


use backend\themes\basic\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script type="text/javascript">window._ROOT_ = '/';</script>
    <script type="text/javascript" src="/js/config.js"></script>
    <script type="text/javascript" src="http://lam2.core/base/System.js"></script>
    <script type="text/javascript">LAM.bootstrap();</script>
    <?php $this->head() ?>
    <?php $this->registerJs($this->blocks['js'], \yii\web\View::POS_END); //将编写的js代码注册到页面底部  ?>
</head>

<body>
<?php $this->beginBody() ?>
<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
    <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#"><?= Html::encode($this->title) ?></a>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <?php

            $navItems = [
                ['label' => '前台', 'url' => Yii::$app->urlManagerFrontend->createUrl('/article/index')],
                ['label' => yii::t('yii','Home'), 'url' => '/site/index'],
            ];
            if (Yii::$app->user->isGuest) {
                $navItems[] = ['label' => yii::t('app','Login'), 'url' => '/site/login'];
                $navItems[] = ['label' => yii::t('app','Signup'), 'url' => '/site/signup'];
            } else {
                $navItems[] = ['label' => '退出 (' . Yii::$app->user->identity->username . ')', 'url' => '/site/logout'];

            }
            $route = Yii::$app->controller->route;
            $route = '/'.$route;

            ?>
            <?php foreach($navItems as $item):?>
                <li class="nav-item <?php if($route == $item['url']){echo 'active';}?>">
                    <!--                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>-->
                    <a class="nav-link" href="<?=$item['url']?>"><?=$item['label']?></a>
                </li>
            <?php endforeach;?>

        </ul>
        <form class="form-inline mt-2 mt-md-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
            <ul class="nav nav-pills flex-column">
                <?php

                if (!Yii::$app->user->isGuest) {
                    $menuItems[] = ['label' => '抓取模版', 'url' => '/catch/index'];
                    $menuItems[] = ['label' => '文章列表', 'url' => '/article/index'];
                    $menuItems[] = ['label' => '商品', 'url' => '/goods/index'];
                    $menuItems[] = ['label' => '视频列表', 'url' => '/video/index'];
                    $menuItems[] = ['label' => '网页地址', 'url' => '/link-address/index'];
                    $menuItems[] = ['label' => '类别管理', 'url' => '/sorts/index'];
                }
                $route = Yii::$app->controller->route;
                $route = '/'.$route;
                ?>
                <?php foreach ($menuItems as $item):?>
                    <li class="nav-item">
                        <a class="nav-link <?php if($route == $item['url']){echo 'active';}?>" href="<?=$item['url']?>"><?=$item['label']?></a>
                    </li>
                <?php endforeach;?>
            </ul>


        </nav>
        <?= Alert::widget() ?>
        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
            <?=$content?>
        </main>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
