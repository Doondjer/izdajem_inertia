<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            if (config('database.default') === 'mysql') {
                DB::statement('CREATE FULLTEXT INDEX listings_fulltext_index ON listings(street, city, county, district, description) WITH PARSER ngram');
            }

            if (config('database.default') === 'sqlite') {
                throw new \Exception('SQLite not supported.');
            }

            if (config('database.default') === 'pgsql') {
                DB::statement('ALTER TABLE listings ADD COLUMN searchable TSVECTOR');
                DB::statement('CREATE INDEX listings_searchable_gin ON listings USING GIN(searchable)');
                DB::statement("CREATE TRIGGER listings_searchable_update BEFORE INSERT OR UPDATE ON listings FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchable', 'pg_catalog.english', 'street', 'city', 'county', 'district', 'description')");
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            //
        });
    }
};
