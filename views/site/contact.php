<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Thank you for contacting us. We will respond to you as soon as possible.
        </div>

        <p>
            Note that if you turn on the Yii debugger, you should be able
            to view the mail message on the mail panel of the debugger.
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Because the application is in development mode, the email is not sent but saved as
                a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                Please configure the <code>useFileTransport</code> property of the <code>mail</code>
                application component to be false to enable email sending.
            <?php endif; ?>
        </p>

    <?php else: ?>

        <p>
            If you have business inquiries or other questions, please fill out the following form to contact us.
            Thank you.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>

<!-- 
<? if ($c_1['child_id'] != null):?>    

                        <? foreach ($c_1.['child'] as $c_2): ?>
                            <div class="comment_2" name="comment_2" value="<? echo $c_2['id'] ?>"  hidden>

                                    <em>Комментатор: </em><strong><? echo $c_2['user'] ?></strong>
                                    <p> <? echo $c_2['text'] ?> </p>

                                        <? if ($c_2['child_id'] != null):?>

                                                <? foreach ($c_2['child'] as $c_3): ?>
                                                    <div class="comment_3" name="comment_3" value="<? echo $c_3['id'] ?>"  hidden >

                                                            <em>Комментатор: </em><strong><? echo $c_3.['user'] ?></strong>
                                                            <p> <? echo $c_3['text'] ?> </p>
                                                            <div id="answer<? echo $c_3['id'] ?>"  hidden>

                                                                <form action='' method="POST">

                                                                    <textarea  name="text" id='add_text_comment_4_<? echo $c_3['id'] ?>' required="" placeholder="Текст комментрия" cols="30" rows="10"></textarea><br>
                                                                    <input type="button" id=4 class="sent_button_comment" value="Оставить комментраий" >  </input>
                                                                </form>


                                                            </div>

                                                            <button type="button" class = "answer_button" value="<? echo $c_3['id'] ?>" >Ответить</button>
                                                            <button type="button" class = "cansel_button" value="<? echo $c_3['id'] ?>" hidden >Отмена</button>
                                                            <? if ($c_3['child_id'] != null): ?>
                                                                <button name=""  type="button" class = "answer_show_button" value="4" >Посмотреть ответы</button>
                                                                <button name=""  type="button" class = "answer_close_button" value="4" hidden>Закрыть</button>
                                                            <? endif ?>
                                                        <br>

                                                         <br>
                                                    </div>
                                                <? endforeach ?>
                                        <? endif ?>
                                    <div id="answer<? echo ($c_2['id']) ?>"  hidden>

                                        <form action='' method="POST">

                                            <textarea  name="text" id='add_text_comment_3_<? echo $c_2['id'] ?>' required="" placeholder="Текст комментрия" cols="30" rows="10"></textarea><br>
                                            <input type="button" id=3 class="sent_button_comment" value="Оставить комментраий" >  </input>

                                        </form>


                                    </div>

                                    <button type="button" class = "answer_button" value="<? echo $c_2['id'] ?>" >Ответить</button>
                                    <button type="button" class = "cansel_button" value="<? echo $c_2['id'] ?>" hidden >Отмена</button>
                                    <? if ($c_2.child_id != null): ?>
                                        <button name="created"  type="button" class = "answer_show_button" value="3" >Посмотреть ответы</button>
                                        <button name="created"  type="button" class = "answer_close_button" value="3" hidden>Закрыть</button>
                                    <? endif ?>

                                <br>
                                 <br>
                            </div>
                        <? endforeach ?>
                <? endif ?> -->