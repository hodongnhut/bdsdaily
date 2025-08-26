<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string $content
 * @property string|null $keywords
 * @property string|null $news_keywords
 * @property string|null $thumb_image
 * @property string|null $tag
 * @property string $author
 * @property int|null $status 0 = Draft, 1 = Published, 2 = Hidden
 * @property string $created_at
 * @property string $updated_at
 */
class NewsExtranaly extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'keywords', 'news_keywords', 'thumb_image', 'tag'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 1],
            [['title', 'slug', 'content', 'author'], 'required'],
            [['description', 'content', 'keywords', 'news_keywords'], 'string'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'slug', 'thumb_image', 'tag'], 'string', 'max' => 255],
            [['author'], 'string', 'max' => 100],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Tiêu Đề',
            'slug' => 'URL SEO',
            'description' => 'Chú Thích',
            'content' => 'Nội Dung',
            'keywords' => 'Keywords',
            'news_keywords' => 'News Keywords',
            'thumb_image' => 'Đường Dẫn Hình Ảnh',
            'tag' => 'HashTag',
            'author' => 'Tác Giả',
            'status' => 'Trạng Thái',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
