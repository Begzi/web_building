<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$js = <<<JS
    $('.change_button').on('click', function(e){
        var b = $('#csrf_token').text().replace('==', '');
        var abs = '_csrf='.concat(b).concat('%3D%3D&CommentForm%5Btext%5D=').concat(e.target.id);;
        
        // отправляем данные на сервер
        $.ajax({
            url: e.target.value, //ссылка
            type: 'post', 
            data: abs,  //csrf токен
            dataType: 'json',
        })
        .done(function(data) {
            console.log(data);
            if (data.success) {

                var parent = e.target.closest('div.comment_1');
                console.log(parent);
                console.log(parent.firstElementChild);
                parent.firstElementChild.innerText = "Статус: Не отправлено";
            }
        })
        .fail(function () {
            alert('Произошла ошибка при отправке данных!');
        })
        return false; // отменяем отправку данных формы
    });
    $('.delete_button').on('click', function(e){
        var b = $('#csrf_token').text().replace('==', '');
        var abs = '_csrf='.concat(b).concat('%3D%3D&CommentForm%5Btext%5D=').concat(e.target.id);
        
        // отправляем данные на сервер
        $.ajax({
            url: e.target.value, //ссылка
            type: 'post', 
            data: abs,  //csrf токен
            dataType: 'json',
        })
        .done(function(data) {
            console.log(data);
            if (data.success) {

                console.log(e.target.closest('div.comment_1'));
                e.target.closest('div.comment_1').remove();
            }
        })
        .fail(function () {
            alert('Произошла ошибка при отправке данных!');
        })
        return false; // отменяем отправку данных формы
    });   

    $('.answer_button').on('click', function(e){
        console.log(e);
        console.log(e.currentTarget.value);
        e.hidden = true;
        var id = e.currentTarget.value
        var div_name = 'answer' + id;
        console.log(div_name);
        document.getElementById('answer' + id).hidden = false;
        document.getElementById('answer_button_' + id).hidden = true;
        document.getElementById('cansel_button_' + id).hidden = false;
    });
    $('.cansel_button').on('click', function(e){
        var id = e.currentTarget.value
        document.getElementById('answer' + id).hidden = true;
        document.getElementById('answer_button_' + id).hidden = false;
        document.getElementById('cansel_button_' + id).hidden = true;
    });
JS;
 
$this->registerJs($js);
?>
<div class="article_id" value="1"></div><h2><?php echo $this->title ?></h2>

<div id='csrf_token' value='<?= Yii::$app->request->getCsrfToken()?>' hidden><?= Yii::$app->request->getCsrfToken()?></div>
<div id='csrf_param' value='<?= Yii::$app->request->csrfParam ?>' hidden></div>

<hr>
<div class="comments" id="comments">

<? if ($comments != null): ?>


    <? foreach ($comments as &$c_1): ?>
        <div class = "comment_1" name= "comment" value = '<? echo $c_1['id'] ?>' >
                <div class="status" name="status" >Статус: Отправлен  </div>

                <em>Комментатор: </em><strong><? echo ($c_1['user']) ?></strong>
                <p> <? echo ((string)$c_1['text']) ?> </p>

                    
                <div id="answer<? echo $c_1['id'] ?>" value="<? echo $c_1['id'] ?>" hidden>

                    <button type="button" class = "delete_button" id = "_delete_button_<? echo $c_1['id'] ?>" value="<?=Yii::$app->urlManager->createUrl(["site/about"])?>" >Удалить</button>
                 
                    <button type="button" class="change_button" id = "_change_button_<? echo $c_1['id'] ?>" value="<?=Yii::$app->urlManager->createUrl(["site/about"])?>"  >Статус: не отправить </button>

                    <hr>
                </div>

                <button type="button" class = "answer_button" id = "answer_button_<? echo $c_1['id'] ?>" value="<? echo $c_1['id'] ?>" >Ответить</button>
                <button type="button" class="cansel_button" id = "cansel_button_<? echo $c_1['id'] ?>" value="<? echo $c_1['id'] ?>" hidden >Отмена</button>


        </div>
        <hr>
    <? endforeach ?>


       <!--  <nav class='list-pages'>
            <ul>
                {% for p in all_comment.paginator.page_range %}
                <li class='page-num'>
                    <a href="?page={{ p }}">{{ p }}</a>
                </li>
                {% endfor %}
            </ul>
        </nav> -->

<? else: ?>
    Комментарии не найдены, станьте первым!
<? endif ?>
</div>
<hr>
<div id="add_comment" >
   <!--  <form action='' id="feedback" method="POST">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />

        <textarea  name="text" id = 'add_text_comment_1' required="" placeholder="Текст комментрия" cols="30" rows="10"></textarea><br>
        <input type="button" id=1 class="sent_button_comment" value="Оставить комментраий"> </input>

    </form> -->

    <?php $form = ActiveForm::begin([
        'id' => 'com-form',
        'layout' => 'horizontal',
        'class' => "pam",   
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-2 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>

        <?= $form->field($model, 'text')->textarea(['autofocus' => true])->label('Ваш комментарий') ?>

        <div class="form-group">
            <div class="offset-lg-3 col-lg-11">
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>




