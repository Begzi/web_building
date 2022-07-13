<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\UserForm;
use app\models\ContactForm;
use app\models\User;
use app\models\CommentForm;
use app\models\Comment;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'contact'],
                'rules' => [
                    [
                        'actions' => ['logout', 'contact'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $comment = Comment::find()->all();

        return $this->render('index', [
            'comment' => $comment,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionReg()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new UserForm();
        if (Yii::$app->request->post()){
            if (Yii::$app->request->isAjax) {
                return $this->goHome();
            }
        }
        if ($model->load(Yii::$app->request->post())) {

            $user = new User;

            $user->login = $model->username;
            $user->password = $model->password;
            $user->name = $model->name;
            $user->phone = $model->phone;
            $user->city = $model->city;
            if ($model->avatar != null)
            {
                $user->avatar = UploadedFile::getInstance($model, 'avatar');
            }
            $user->date = $model->date;
            $user->hash = Yii::$app->getSecurity()->generatePasswordHash($model->password);
            $user->save();


            $model_login = new LoginForm();
            $model_login->username = $model->username;
            $model_login->password = $model->password;
            if ($model_login->login()) {
                return $this->goBack();
            }
            else
            {
                return $this->goHome();

            }

        }


        return $this->render('reg', [
            'model' => $model
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        $model = new CommentForm;


        if ($model->load(Yii::$app->request->post())) {
            

            if (Yii::$app->request->isAjax) {

                preg_match_all("/\d+/", $model->text, $id_comment);
                $comment = Comment::findOne($id_comment[0][0]);
                $pos = strpos($model->text, 'delete');
                if ($pos > 0){
                    $comment->delete();
                }else{
                    $comment->text = 'changed';
                    $comment->save();
                }

                Yii::$app->response->format = Response::FORMAT_JSON;
                $response = [
                    'success' => true,
                    'check' => $id_comment[0][0],
                    'pos' => $pos,
                    'comment' => $comment
                ];
                return $response;
            } 
            
            $comment = new Comment;

            $comment->text = $model->text;
            $comment->user = 1;
            $comment->save();
            // выполняем редирект, чтобы избежать повторной отправки формы
            return $this->refresh();
        }
        $comments = Comment::find()->all();
        return $this->render('about', [
            'comments' => $comments,
            'model' => $model,
        ]);
    }

}
