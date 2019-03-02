<?php

namespace app\controllers;

use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\Article;
use yii\data\Pagination;
use app\models\Category;

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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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

        $data=Article::getAll(1);

        $popular=Article::getPopular();

        $recent=Article::getRecent();

        $categories=Category::getAll();
        return $this->render('index',
            [
                'articles'=>$data['articles'],
                'pagination'=>$data['pagination'],
                'popular' =>$popular,
                'recent' =>$recent,
                'categories' =>$categories
            ]);
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
        return $this->render('about');
    }

    public function actionSay($message='Hello,world!')
    {
        return $this->render('say',['message'=>$message]);
    }
    public function actionEntry()
    {
        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            return $this->render('entry', ['model' => $model]);
        }
    }

    public function actionView($id){

        $article=Article::findOne($id);

        $popular=Article::getPopular();

        $recent=Article::getRecent();

        $categories=Category::getAll();

        return $this->render('single',[
            'article'=>$article,
            'popular' =>$popular,
            'recent' =>$recent,
            'categories' =>$categories
        ]);
    }

    public function actionCategory($id){

        $data=Category::getArticlesByCategory($id);
        $popular=Article::getPopular();
        $recent=Article::getRecent();
        $categories=Category::getAll();

        return $this->render('category',[
            'articles'  =>  $data['articles'],
            'pagination'=>  $data['pagination'],
            'popular'   => $popular,
            'recent'   => $recent,
            'categories'   => $categories
        ]);
    }

}
