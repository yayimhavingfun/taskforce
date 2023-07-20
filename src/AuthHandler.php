<?php
namespace app\src;

use app\models\Auth;
use app\models\Cities;
use app\models\Users;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use yii\httpclient\Exception;
use app\helpers\Helpers;

class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $attr = $this->client->getUserAttributes();
        $email = ArrayHelper::getValue($attr, 'email');

        $auth = Auth::find()->where([
           'source' => $this->client->getId(),
           'source_id' => $attr['id'],
        ])->one();

        if ($auth) {
            Yii::$app->user->login($auth->user);
        } else {
            if (isset($email) && Users::find()->where(['email' => $email])->exists()) {
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app', "Пользователь с такой электронной почтой как в {client} уже существует, но с ним не связан"),
                ]);
            } else {
                $city_ru = Helpers::transliterate($attr['city']['title']);
                if (isset($attr['city']['title'])) {
                    $city = Cities::find()->where(['name' => $city_ru])->one();
                }
                $password = Yii::$app->security->generateRandomString(6);

                $user = new Users([
                    'name' => $attr['first_name'],
                    'email' => $attr['email'],
                    'city_id' => $city->id,
                    'password' => Yii::$app->security->generatePasswordHash($password),
                ]);

                if ($user->save()) {
                    $auth = new Auth([
                        'user_id' => $user->id,
                        'source' => $this->client->getId(),
                        'source_id' => (string) $attr['id'],
                    ]);
                    $auth->save();

                    Yii::$app->user->login($user);
                }
            }
        }
    }
}