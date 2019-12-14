<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
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
    <script type="text/javascript" src="http://127.0.0.1/lamborghiniJS/LAM2/lamborghiniJS/base/System.js"></script>
    <script type="text/javascript">LAM.bootstrap();</script>

    <?php $this->head() ?>
    <script type="text/javascript">
        <?php $this->beginBlock('js'); ?>
        $(function () {
            LAM.listen(function () {
                cg.innerHTML=new Date().toLocaleString();
            },1000);
        });

        <?php $this->endBlock(); ?>
    </script>

    <?php $this->registerJs($this->blocks['js'], \yii\web\View::POS_END); //将编写的js代码注册到页面底部  ?>

</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '前台', 'url' => Yii::$app->urlManagerFrontend->createUrl('/article/index')],
        ['label' => yii::t('yii','Home'), 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => yii::t('app','Login'), 'url' => ['/site/login']];
        $menuItems[] = ['label' => yii::t('app','Signup'), 'url' => ['/site/signup']];
    } else {
        $menuItems[] = ['label' => '抓取模版', 'url' => ['/catch/index']];
        $menuItems[] = ['label' => '文章列表', 'url' => ['/article/index']];
        $menuItems[] = ['label' => '视频列表', 'url' => ['/video/index']];
        $menuItems[] = ['label' => '网页地址', 'url' => ['/link-address/index']];
        $menuItems[] = ['label' => '类别', 'url' => ['/sorts/index']];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                '退出 (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo '<span style="color: #fff;position: relative;top:15px;">当前北京时间：<span id="cg"></span></span>';
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
