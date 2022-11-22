<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221122102100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY fk_cart_user');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY fk_product_cart');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY fk_product_category_item');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY fk_product_user');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE category_item');
        $this->addSql('DROP TABLE product');
        $this->addSql('ALTER TABLE user ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, DROP is_admin, CHANGE pseudo pseudo VARCHAR(180) NOT NULL, CHANGE adress adress VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE rating rating INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64986CC499D ON user (pseudo)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, status_validation TINYINT(1) DEFAULT 0, date DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX fk_cart_user (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE category_item (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, description VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, photo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, logo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, in_carousel TINYINT(1) DEFAULT 0, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_item_id INT NOT NULL, user_id INT NOT NULL, cart_id INT DEFAULT NULL, title VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, price INT NOT NULL, description TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, photo JSON NOT NULL, status VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'en vente\' COLLATE `utf8mb4_0900_ai_ci`, material JSON NOT NULL, category_room JSON NOT NULL, color JSON NOT NULL, date DATETIME DEFAULT CURRENT_TIMESTAMP, `condition` VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, show_phone_user TINYINT(1) DEFAULT 0, show_email_user TINYINT(1) DEFAULT 0, INDEX fk_product_category_item (category_item_id), INDEX fk_product_user (user_id), INDEX fk_product_cart (cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT fk_cart_user FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT fk_product_cart FOREIGN KEY (cart_id) REFERENCES cart (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT fk_product_category_item FOREIGN KEY (category_item_id) REFERENCES category_item (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT fk_product_user FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP INDEX UNIQ_8D93D64986CC499D ON user');
        $this->addSql('ALTER TABLE user ADD is_admin TINYINT(1) DEFAULT 0, DROP roles, DROP password, CHANGE pseudo pseudo VARCHAR(20) NOT NULL, CHANGE adress adress VARCHAR(80) NOT NULL, CHANGE email email VARCHAR(50) NOT NULL, CHANGE rating rating INT DEFAULT 5');
    }
}
