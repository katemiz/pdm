<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Counter;
use App\Models\Company;
use App\Models\Malzeme;
use App\Models\NoteCategory;
use App\Models\User;
use App\Models\Pnote;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\CRequest::factory(10)->create();

        Company::create([
            'user_id' => 1,
            'updated_uid' =>1,
            'name' => 'kapkara',
            'fullname' => 'Web Technologies Company'
        ]);


        Company::create([
            'user_id' => 1,
            'updated_uid' =>1,
            'name' => 'Masttech',
            'fullname' => 'Elektromekanik Sistemler Sanayii ve Ticaret AŞ'
        ]);

        Company::create([
            'user_id' => 1,
            'updated_uid' =>1,
            'name' => 'Inttow',
            'fullname' => 'Intelligent Towers Sanayii ve Ticaret AŞ'
        ]);

        $admin = User::create([
            "name" => 'Kılıç Ali',
            "lastname" =>'Temiz',
            "company_id" => 1,
            "email" => 'katemiz@kapkara.one',
            "password" => 'password'
        ]);


        \App\Models\CRequest::factory()->count(10)->create();

        Role::create(['name' => 'EngineeringDept']);
        Role::create(['name' => 'OperationsDept']);
        Role::create(['name' => 'ProcurementDept']);
        Role::create(['name' => 'QualityDept']);
        Role::create(['name' => 'SalesDept']);

        Role::create(['name' => 'Approver']);
        Role::create(['name' => 'Checker']);
        Role::create(['name' => 'Viewer']);

        $adminRole = Role::create(['name' => 'admin']);
        $admin->assignRole('admin');

        $engineeringPerm = Permission::create(['name' => 'engineering']);
        $crApproverPerm = Permission::create(['name' => 'cr_approver']);
        $engApproverPerm = Permission::create(['name' => 'eng_approver']);
        $engCheckerPerm = Permission::create(['name' => 'eng_checker']);

        $adminRole->givePermissionTo($engineeringPerm);

        // Note Categories
        NoteCategory::create([
            'user_id' => 1,
            'text_en' => 'General Notes',
            'text_tr' => 'Genel Notlar',
        ]);

        NoteCategory::create([
            'user_id' => 1,
            'text_en' => 'Surface Protection',
            'text_tr' => 'Yüzey Koruma',
        ]);

        NoteCategory::create([
            'user_id' => 1,
            'text_en' => 'Surface Protection - Painting',
            'text_tr' => 'Yüzey Koruma - Boyama',
        ]);


        NoteCategory::create([
            'user_id' => 1,
            'text_en' => 'Mechanical Fastening',
            'text_tr' => 'Mekanik Bağlayıcılar',
        ]);

        NoteCategory::create([
            'user_id' => 1,
            'text_en' => 'Bonding',
            'text_tr' => 'Yapıştırma',
        ]);

        // NOTES

        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 2,
            'text_tr' => "Demir ve Çelik > Çinko kaplama ASTM B633-13, SC 4, Type II (Renkli)",
            'text_en' => "Iron and Steels > Zinc plating per ASTM B633-13, SC 4, Type II (Colored)",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 1,
            'text_tr' => "Verilmeyen Ölçü ve Ayrıntılar için 3B - CAD [3 Boyutlu Bilgisayar ] Modeli kullanılacaktır.",
            'text_en' => "3D CAD Model shall be used for dimensions and features not given in the drawing.",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 1,
            'text_tr' => "Verilmediği müddetçe, talaşlı imalat için kullanılacak parmak freze boyutları 16 mm çap ve dip burun yarıçapı 4 mm olacaktır.",
            'text_en' => "For default milling cutter dimension : Diameter 16 mm with 4 mm end radius",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 1,
            'text_tr' => "Tüm sivri köşeleri yuvarlatın ve çapakları temizleyiniz",
            'text_en' => "Break all sharp edges and remove all burrs",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 2,
            'text_tr' => "Alüminyum Alaşımları > Kimyasal (Kromat) Dönüşüm Kaplaması, MIL-DTL-5541F, TIP I SINIF 1A (SARI)",
            'text_en' => "Aluminium Alloys > Chemical Film Conversion per MIL-DTL-5541F, Type I Class 1A (Gold/Brown)",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 2,
            'text_tr' => "Alüminyum Alaşımları > Kimyasal (Kromat) Dönüşüm Kaplaması, MIL-DTL-5541F, TIP I SINIF 1A (Renksiz)",
            'text_en' => "Aluminium Alloys > Chemical Film Conversion per MIL-DTL-5541F, Type I Class 1A (Clear)",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 2,
            'text_tr' => "Alüminyum Alaşımları > Eloksal Kaplama, MIL-A-8625F, Tip II, Sınıf 1, 20 μm (Renksiz) [Doğal Renk : Mat Hafif Gri]",
            'text_en' => "Aluminium Alloys > Sulphuric Acid Anodizing per MIL-A-8625F, Type II, Class 1, 20 μm (Clear) [Natural Color : Grey]",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 2,
            'text_tr' => "Alüminyum Alaşımları > Eloksal Kaplama, MIL-A-8625F, Tip II, Sınıf 2, 20 μm (Renkli)",
            'text_en' => "Aluminium Alloys > Sulphuric Acid Anodizing per MIL-A-8625F, Type II, Class 2, 20 μm (Colored)",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 2,
            'text_tr' => "Renk, Eloksal  > Eloksal Kaplama Rengi RAL 9005 Siyah olacaktır.",
            'text_en' => "Color, Anodizing > Anodizing color shall be RAL 9005 Black.",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 2,
            'text_tr' => "Paslanmaz Çelik > Pasivasyon, ASTM A967-05",
            'text_en' => "Stainless Steels > Chemical Passivation Treatment per ASTM A967-05",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 2,
            'text_tr' => "Metaller > Çinko-Nikel kaplama ASTM B841-99 Tip A, Kalınlık Sınıfı 10 (Renksiz)",
            'text_en' => "Metals > Electrodeposited Zinc Nickel Plating per ASTM B841-99 Type A, Grade 10 (Colorless)",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 2,
            'text_tr' => "Metaller > Çinko-Nikel kaplama ASTM B841-99 Tip B, Kalınlık Sınıfı 10  (Sarı)",
            'text_en' => "Metals > Electrodeposited Zinc Nickel Plating per ASTM B841-99 Type B, Grade 10 (Yellow - Iridescent)",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 2,
            'text_tr' => "Metaller > Çinko-Nikel kaplama ASTM B841-99 Tip C, Kalınlık Sınıfı 10  (Bronz Rengi)",
            'text_en' => "Metals > Electrodeposited Zinc Nickel Plating per ASTM B841-99 Type A, Grade 10 (Bronze)",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 2,
            'text_tr' => "Metaller > Çinko-Nikel kaplama ASTM B841-99 Tip D, Kalınlık Sınıfı 10 (Siyah)",
            'text_en' => "Metals > Electrodeposited Zinc Nickel Plating per ASTM B841-99 Type D, Grade 10 (Black)",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 2,
            'text_tr' => "Renk, Çinko Kaplama> Siyah, RAL 9005",
            'text_en' => "Color, Zinc Plating > Black, RAL 9005",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 2,
            'text_tr' => "Demir ve Çelik > Çinko kaplama ASTM B633-13, SC 3, Type II (Renkli)",
            'text_en' => "Iron and Steels > Zinc plating per ASTM B633-13, SC 3, Type II (Colored)",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 2,
            'text_tr' => "Renk, Çinko Kaplama> Beyaz, RAL 9016 ",
            'text_en' => "Color, Zinc Plating > White, RAL 9016",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 2,
            'text_tr' => "Metaller > Katı Film Yağlayıcı M-46010-1, MIL-PRF-46010H [Doğal Renk]",
            'text_en' => "Metals > Solid Film Lubricate M-46010-1 per MIL-PRF-46010H [Natural Color]",
            'status' => "A"
        ]);


        Pnote::create([
            'user_id' => 1,
            'note_category_id' => 2,
            'text_tr' => "Metaller > Katı Film Yağlayıcı M-46010-2, MIL-PRF-46010H [Siyah]",
            'text_en' => "Metals > Solid Film Lubricate M-46010-2 per MIL-PRF-46010H [Black]",
            'status' => "A"
        ]);




        Malzeme::create([
            'user_id' => 1,
            'form' => '300',
            'family' => '200',
            'description' => 'St 37-2 / 1.0037',
            'specification' => 'DIN 17100 / EN 10025',
            'status' => 'A'
        ]);

        Malzeme::create([
            'user_id' => 1,
            'form' => '300',
            'family' => '200',
            'description' => 'St 44-2 / 1.0044',
            'specification' => 'DIN 17100 / EN 1002',
            'status' => 'A'
        ]);

    }
}

