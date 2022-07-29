<?php

class RbacController extends \yii\console\Controller
{
    /**
     * @throws \yii\base\Exception
     * @throws Exception
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // добавляем разрешение "createPost"
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // добавляем разрешение "updatePost"
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        $deletePost = $auth->createPermission('deletePost');
        $deletePost->description = 'Post post';
        $auth->add($deletePost);

        // добавляем разрешение "modifyPost"
        $modifyPost = $auth->createPermission('modifyPost');
        $modifyPost->description = 'Modify post';
        $auth->add($modifyPost);
        // добавляем разрешение "createPost, updatePost, deletePost" к "modifyPost"
        $auth->addChild($modifyPost, $createPost);
        $auth->addChild($modifyPost, $updatePost);
        $auth->addChild($modifyPost, $deletePost);

        $publishPost = $auth->createPermission('publishPost');
        $publishPost->description = 'Publish post';
        $auth->add($publishPost);

        $viewPost = $auth->createPermission('viewPost');
        $viewPost->description = 'View post';
        $auth->add($viewPost);

        // добавляем роль "author" и даём роли разрешение "createPost"
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);

        $manager = $auth->createRole('manager');
        $auth->add($manager);
        // добавляем разрешение "publishPost, viewPost " к "manager"
        $auth->addChild($manager, $publishPost);
        $auth->addChild($manager, $viewPost);

        $user = $auth->createRole('user');
        $auth->add($user);
        // добавляем разрешение "createPost, updatePost, deletePost" к "user"
        $auth->addChild($user, $createPost);
        $auth->addChild($user, $updatePost);
        $auth->addChild($user, $deletePost);

        // добавляем роль "admin" и даём роли разрешение "updatePost"
        // а также все разрешения роли "author"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        // добавляем разрешение "modifyPost, publishPost, viewPost" к "admin"
        $auth->addChild($admin, $modifyPost);
        $auth->addChild($admin, $publishPost);
        $auth->addChild($admin, $viewPost);

        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.
        $auth->assign($moder, 3);
        $auth->assign($author, 2);
        $auth->assign($admin, 1);
    }
}