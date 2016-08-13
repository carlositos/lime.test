<?php

namespace app\models\wordpress;

use Yii;

/**
 * This is the model class for table "global_wp_posts".
 *
 * @property string $id
 * @property integer $source_id
 * @property string $link
 * @property string $creator
 * @property string $post_date
 * @property string $post_date_gmt
 * @property string $post_content
 * @property string $post_title
 * @property string $post_excerpt
 * @property string $post_status
 * @property string $comment_status
 * @property string $ping_status
 * @property string $post_password
 * @property string $post_name
 * @property string $post_parent
 * @property string $guid
 * @property integer $menu_order
 * @property string $post_type
 */
class GlobalWpPosts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'global_wp_posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['source_id', 'post_id'], 'required'],
            [['source_id', 'post_id', 'post_parent', 'menu_order'], 'integer'],
            [['post_date', 'post_date_gmt'], 'safe'],
            [['post_content', 'post_title', 'post_excerpt'], 'string'],
            [['link', 'creator', 'guid'], 'string', 'max' => 255],
            [['post_status', 'comment_status', 'ping_status', 'post_password', 'post_type'], 'string', 'max' => 20],
            [['post_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'source_id' => 'Source ID',
            'link' => 'Link',
            'creator' => 'Creator',
            'post_date' => 'Post Date',
            'post_date_gmt' => 'Post Date Gmt',
            'post_content' => 'Post Content',
            'post_title' => 'Post Title',
            'post_excerpt' => 'Post Excerpt',
            'post_status' => 'Post Status',
            'comment_status' => 'Comment Status',
            'ping_status' => 'Ping Status',
            'post_password' => 'Post Password',
            'post_name' => 'Post Name',
            'post_parent' => 'Post Parent',
            'guid' => 'Guid',
            'menu_order' => 'Menu Order',
            'post_type' => 'Post Type',
        ];
    }

	
}
