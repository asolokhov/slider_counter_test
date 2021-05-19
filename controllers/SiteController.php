<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\helpers\LoadNewsHelper;
use app\models\News;
use app\models\Statistic;

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
		
        $session = Yii::$app->session;
        
        $count = News::find()->count();
        if ($count == 0)
        {
            LoadNewsHelper::loadNews();
		    return $this->render('news');
        }
		$offset = mt_rand ( 1 ,  $count - 7 );
        //Если будет равно рандом
        /*if ($count == $offset)
        {
             $offset =  $offset - 7;
        }*/
        //$my_model = 
        //$myModel =
        // 
		$model = News::find()->limit(7)->offset($offset)->all();

		//Записываем в сессию
        if (!isset($session['session_id']))
        {   
            $session_id = uniqid(session_id(), true);
            $session->set('session_id', $session_id); 
        }
        else
        {
            $session_id = $session['session_id'];
        }

        return $this->render('index', [
            'model' => $model,
            'session_id' => $session_id
        ]);
    }
	
	/**
     * Load news.
     *
	 *
     */
    public function actionLoad()
    {
		LoadNewsHelper::loadNews();
		return $this->render('news');
    }

    /**
     * Statustic news.
     *
	 *
     */
    public function actionStatistic()
    {

        $model = Statistic::find()->alias('s')
            ->select(['*, sum(view_count) as view_count'])
            ->groupBy('s.news_id')
            ->orderBy([
                'view_count' => SORT_DESC
              ])
			->all();
		
		return $this->render('statistic', [
            'model' => $model
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
        return $this->render('about');
    }
}
