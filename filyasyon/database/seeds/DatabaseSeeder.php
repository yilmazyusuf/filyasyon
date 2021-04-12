<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $patientStatusesData = [
            ['name' => 'Haliyle Taburcu'],
            ['name' => 'Yurtta Haliyle Taburcu'],
            ['name' => 'Evde Şifa İle Taburcu'],
            ['name' => 'Yurtta Şifa İle Taburcu'],
            ['name' => 'Evde'],
            ['name' => 'Hastanede'],
            ['name' => 'İyileşti'],
            ['name' => 'Ex']
        ];

        \App\Models\PatientStatus::truncate();
        $pateintStatus = \App\Models\PatientStatus::insert($patientStatusesData);
        $this->command->info('PatientStatus  table seeded!');


        // $this->call(UsersTableSeeder::class);
        $db     = \Illuminate\Support\Facades\Config::get('database.connections.mysql.database');
        $user   = \Illuminate\Support\Facades\Config::get('database.connections.mysql.username');
        $pass   = \Illuminate\Support\Facades\Config::get('database.connections.mysql.password');

        Schema::dropIfExists('cities');
        $path = database_path('seeds/sql/cities.sql');
        DB::unprepared(file_get_contents($path));

        Schema::dropIfExists('towns');
        $path = database_path('seeds/sql/towns.sql');
        DB::unprepared(file_get_contents($path));

        Schema::dropIfExists('villages');
        $path = database_path('seeds/sql/villages.sql');
        DB::unprepared(file_get_contents($path));
        //exec("mysql -u " . $user . " -p" . $pass . " " . $db . " < $path");

        Schema::dropIfExists('neighborhoods');
        $path = database_path('seeds/sql/neighborhoods.sql');
        DB::unprepared(file_get_contents($path));
        //exec("mysql -u " . $user . " -p" . $pass . " " . $db . " < $path");


        $this->command->info('Cities, Towns, Villages Neighborhoods  table seeded!');

        $btsData = [
            ['name' => 'Uyumlu'],
            ['name' => 'Uyumlu Değil'],
            ['name' => 'Çekilmedi']
        ];
        \App\Models\Bt::truncate();
        \App\Models\Bt::insert($btsData);
        $this->command->info('bt  table seeded!');

        $contactPlacesData = [
            ['name' => 'Ev'],
            ['name' => 'Aile'],
            ['name' => 'İş Yeri'],
            ['name' => 'Araç İçi'],
            ['name' => 'Yurt Dışı'],
            ['name' => 'Diğer'],
            ['name' => 'Bilinmiyor'],
        ];

        \App\Models\ContactPlace::truncate();
        \App\Models\ContactPlace::insert($contactPlacesData);
        $this->command->info('ContactPlace  table seeded!');

        $healthPersonnelProfessionsData = [
            ['name' => 'Doktor'],
            ['name' => 'Yardımcı Sağlık Personeli'],
            ['name' => 'Memur'],
            ['name' => 'Tem Görevlisi'],
            ['name' => 'Güvenlik Görevlisi'],
            ['name' => 'Diğer']
        ];

        \App\Models\HealthPersonnelProfession::truncate();
        \App\Models\HealthPersonnelProfession::insert($healthPersonnelProfessionsData);
        $this->command->info('HealthPersonnelProfession  table seeded!');


        $contactOriginsData = [
            ['name' => 'Asıl Vaka Adı Soyadı'],
            ['name' => 'Kendisi']
        ];

        \App\Models\ContactOrigin::truncate();
        \App\Models\ContactOrigin::insert($contactOriginsData);
        $this->command->info('ContactOrigin  table seeded!');


        $relationshipMoMainCasesData = [
            ['name' => 'Anne'],
            ['name' => 'Baba'],
            ['name' => 'Çocuk'],
            ['name' => 'Eş'],
            ['name' => 'Hala'],
            ['name' => 'Teyze'],
            ['name' => 'Amca'],
            ['name' => 'Dayı'],
            ['name' => 'Kardeş'],
            ['name' => 'Gelin'],
            ['name' => 'Damat'],
            ['name' => 'Torun'],
            ['name' => 'Komşu'],
            ['name' => 'Arkadaş'],
            ['name' => 'İş Arkadaşı'],
            ['name' => 'Kendisi'],
            ['name' => 'Diğer'],
        ];

        \App\Models\RelationshipToMainCase::truncate();
        \App\Models\RelationshipToMainCase::insert($relationshipMoMainCasesData);
        $this->command->info('RelationshipToMainCase  table seeded!');



    }
}
