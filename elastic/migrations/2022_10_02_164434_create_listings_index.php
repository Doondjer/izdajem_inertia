<?php
declare(strict_types=1);

use Elastic\Adapter\Indices\Mapping;
use Elastic\Adapter\Indices\Settings;
use Elastic\Migrations\Facades\Index;
use Elastic\Migrations\MigrationInterface;

final class CreateListingsIndex implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::create('listings', function (Mapping $mapping, Settings $settings) {
            $mapping->integer('id');
            $mapping->keyword('slug', ['fields' => ['text' => ['type' => 'text']]]);
            $mapping->text('description');
            $mapping->keyword('city', ['fields' => ['text' => ['type' => 'text']]]);
            $mapping->keyword('county', ['fields' => ['text' => ['type' => 'text']]]);
            $mapping->keyword('country', ['fields' => ['text' => ['type' => 'text']]]);
            $mapping->keyword('district', ['fields' => ['text' => ['type' => 'text']]]);
            $mapping->text('street');
            $mapping->keyword('nb_room_human', ['fields' => ['text' => ['type' => 'text']]]);
            $mapping->keyword('type_human', ['fields' => ['text' => ['type' => 'text']]]);
          //  $mapping->keyword('renovation_human', ['fields' => ['text' => ['type' => 'text']]]);
            $mapping->keyword('furnish_type_human', ['fields' => ['text' => ['type' => 'text']]]);
            $mapping->text('size', ['fields' => ['keyword' => ['type' => 'keyword']]]);
            $mapping->keyword('status');
            $mapping->date('status_updated_at');
            $mapping->keyword('user_id');
            $mapping->integer('price');
            $mapping->date('created_at');
            $mapping->date('updated_at');
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::dropIfExists('listings');
    }
}
