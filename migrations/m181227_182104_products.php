<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m181227_182104_products
 */
class m181227_182104_products extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName ==='mysql' )
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=INNODB';

        $this->createTable('{{%products}}',[
            'id'=>Schema::TYPE_PK,//id -авто інкримент з primary key
            'productname'=>$this->string(255)->notNull(),
            'price'=>$this->string(20),
            'oldprice'=>$this->string(20),
            'created_at'=>$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at'=>$this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ],$tableOptions);

        $this->createTable('{{%images}}', [
            'id'=>Schema::TYPE_PK,
            'product_id'=>$this->integer(11),
            'url'=>$this->string(255)
        ], $tableOptions);

        $this->createIndex('idx-images-product_id', '{{%images}}', 'product_id');

        $this->addForeignKey('fk-images-product_id',
            '{{%images}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%categories}}',[
            'id'=>Schema::TYPE_PK,//id -авто інкримент з primary key
            'category'=>$this->string(255)->notNull(),
        ],$tableOptions);

        $this->createTable('{{%product_category}}', [
            'product_id'=>$this->integer(11),
            'category_id'=>$this->integer(11),
            'PRIMARY KEY(product_id, category_id)'
        ], $tableOptions);

        $this->createIndex('idx-product_category-product_id', '{{%product_category}}', 'product_id');

        $this->addForeignKey('fk-product_category-product_id',
            '{{%product_category}}',
            'product_id',
            '{{%products}}',
            'id',
            'NO ACTION'
        );

        $this->createIndex('idx-product_category-category_id', '{{%product_category}}', 'category_id');

        $this->addForeignKey('fk-product_category-category_id',
            '{{%product_category}}',
            'category_id',
            '{{%categories}}',
            'id',
            'NO ACTION'
        );

        $this->createTable('{{%customer_product}}', [
            'customer_id'=>$this->integer(11),
            'product_id'=>$this->integer(11),
            'PRIMARY KEY(customer_id, product_id)'
        ], $tableOptions);

        $this->createIndex('idx-customer_product-customer_id', '{{%customer_product}}', 'customer_id');

        $this->addForeignKey('fk-customer_product-customer_id',
            '{{%customer_product}}',
            'customer_id',
            '{{%customers}}',
            'id',
            'CASCADE'
        );

        $this->createIndex('idx-customer_product-product_id', '{{%customer_product}}', 'product_id');

        $this->addForeignKey('fk-customer_product-product_id',
            '{{%customer_product}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%description}}',[
            'id'=>Schema::TYPE_PK,//id -авто інкримент з primary key
            'product_id'=>$this->integer(11),
            'key'=>$this->string(400),
            'value'=>$this->string(400),
        ],$tableOptions);

        $this->createIndex('idx-description-product_id', '{{%description}}', 'product_id');

        $this->addForeignKey('fk-description-product_id',
            '{{%description}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%reviews}}',[
            'id'=>Schema::TYPE_PK,//id -авто інкримент з primary key
            'product_id'=>$this->integer(11),
            'name'=>$this->string(200),
            'text'=>$this->string(5000),
        ],$tableOptions);

        $this->createIndex('idx-reviews-product_id', '{{%reviews}}', 'product_id');

        $this->addForeignKey('fk-reviews-product_id',
            '{{%reviews}}',
            'product_id',
            '{{%products}}',
            'id',
            'NO ACTION'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products}}');
        $this->dropTable('{{%images}}');
        $this->dropTable('{{%categories}}');
        $this->dropTable('{{%product_category}}');
        $this->dropTable('{{%customer_product}}');

        $this->dropIndex('idx-images-product_id', '{{%images}}');
        $this->dropForeignKey('fk-images-product_id', '{{%images}}');

        $this->dropIndex('idx-product_category-product_id', '{{%product_category}}');
        $this->dropForeignKey('fk-product_category-product_id', '{{%product_category}}');
        $this->dropIndex('idx-product_category-category_id', '{{%product_category}}');
        $this->dropForeignKey('fk-product_category-category_id', '{{%product_category}}');

        $this->dropIndex('idx-customer_product-customer_id', '{{%customer_product}}');
        $this->dropForeignKey('fk-customer_product-customer_id', '{{%customer_product}}');
        $this->dropIndex('idx-customer_product-product_id', '{{%customer_product}}');
        $this->dropForeignKey('fk-customer_product-product_id', '{{%customer_product}}');

        $this->dropTable('{{%description}}');
        $this->dropIndex('idx-description-product_id', '{{%description}}');
        $this->dropForeignKey('fk-description-product_id', '{{%description}}');

        $this->dropTable('{{%reviews}}');
        $this->dropIndex('idx-reviews-product_id', '{{%reviews}}');
        $this->dropForeignKey('fk-reviews-product_id', '{{%reviews}}');

        echo "m181227_182104_products cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181227_182104_products cannot be reverted.\n";

        return false;
    }
    */
}
