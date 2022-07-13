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
    $('form').on('beforeSubmit', function(){
    var form = $(this);
    var data = form.serialize();
    // отправляем данные на сервер
    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: data
    })
    .done(function(data) {
        if (data.success) {
            // данные прошли валидацию, сообщение было отправлено
            $('#response').html(data.message);
            form.children('.has-success').removeClass('has-success');
            form[0].reset();
        }
    })
    .fail(function () {
        alert('Произошла ошибка при отправке данных!');
    })
    return false; // отменяем отправку данных формы
    });
JS;
 
$this->registerJs($js);
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
            'inputOptions' => ['class' => 'col-lg-3 form-control'],
            'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин<font color="f33810">*</font>'); ?>

        <?= $form->field($model, 'password')->passwordInput()->label('Пароль<font color="f33810">*</font>'); ?>

        <?= $form->field($model, 'check_password')->passwordInput()->label('Повтор пароля<font color="f33810">*</font>'); ?>

        <?= $form->field($model, 'name')->textInput()->label('ФИО<font color="f33810">*</font>'); ?>

        <?= $form->field($model, 'date')->widget(DatePicker::className(),[
                    'name' => 'date',
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => ['placeholder' => 'Выберите дату...'],
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'format' => 'yyyy-MM-dd',
                        'autoclose'=>true,
                        'weekStart'=>1, //неделя начинается с понедельника
                        'startDate' => '01.01.1950', //самая ранняя возможная дата
                        'todayBtn'=>true, //снизу кнопка "сегодня"
                    ]
                ])->label('Дата рождения<font color="f33810">*</font>'); ?>

        <?= $form->field($model, 'city')->textInput()->label('Город<font color="f33810">*</font>'); ?>

        <?= $form->field($model, 'phone')->textInput()->label('Номер телефона<font color="f33810">*</font>'); ?>

        <?= $form->field($model, 'avatar')->fileInput(  ['accept'=>'.jpg, .jpeg, .png, .pdf'])->label('Выберите аватар'); ?>

     

        <div class="form-group">
            <div class="offset-lg-1 col-lg-11">
                <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
