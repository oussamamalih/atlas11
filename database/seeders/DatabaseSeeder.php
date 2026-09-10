<?php

namespace Database\Seeders;

use App\Models\PlayerProfile;
use App\Models\ScoutProfile;
use App\Models\ScoutingInterest;
use App\Models\User;
use App\Notifications\ScoutingInterestReceived;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear existing records to ensure a fresh, consistent seed
        Schema::disableForeignKeyConstraints();
        DB::table('notifications')->truncate();
        ScoutingInterest::truncate();
        PlayerProfile::truncate();
        ScoutProfile::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // -------------------------------------------------------------
        // 1. Primary Demo / Test Accounts (Easy Login with 'password')
        // -------------------------------------------------------------

        // 1.1 System Administrator
        $admin = User::create([
            'name' => 'Atlas Administrator',
            'email' => 'admin@atlas11.com',
            'password' => 'password',
            'role' => User::ROLE_ADMIN,
            'email_verified_at' => now(),
        ]);

        // 1.2 Lead Scout Account
        $leadScoutUser = User::create([
            'name' => 'Karim Benjelloun',
            'email' => 'scout@atlas11.com',
            'password' => 'password',
            'role' => User::ROLE_SCOUT,
            'email_verified_at' => now(),
        ]);

        $leadScoutProfile = ScoutProfile::create([
            'user_id' => $leadScoutUser->id,
            'organization' => 'Royal Moroccan Football Federation (FRMF)',
            'role_title' => 'National Youth Talent Scout',
            'location' => 'Rabat',
            'experience_years' => 12,
            'phone' => '+212 661 123456',
            'license_number' => 'FRMF-A-8821',
            'bio' => 'Certified CAF/FRMF technical scout with 12+ years of talent discovery across national youth leagues. Focused on identifying elite tactical intelligence, spatial awareness, and transition athletes across Moroccan Botola academies.',
        ]);

        // 1.3 Featured Player Account (Matches hero/brand persona)
        $featuredPlayerUser = User::create([
            'name' => 'Yassine El Idrissi',
            'email' => 'player@atlas11.com',
            'password' => 'password',
            'role' => User::ROLE_PLAYER,
            'email_verified_at' => now(),
        ]);

        $featuredPlayerProfile = PlayerProfile::create([
            'user_id' => $featuredPlayerUser->id,
            'position' => 'Midfielder',
            'date_of_birth' => '2006-04-18',
            'location' => 'Casablanca',
            'preferred_foot' => 'Left',
            'height' => 178,
            'weight' => 71,
            'current_club' => 'Raja CA Youth',
            'football_experience' => 'Formed at Raja Club Athletic youth academy since U-12. Captained the U-17 regional championship-winning side. Recorded 24 starts, 8 goals, and 14 assists in the 2025/2026 youth championship campaign.',
            'bio' => 'Dynamic attacking midfielder (CAM/RW) distinguished by rapid ball progression, vision between defensive lines, close-quarters dribbling in high-tempo phases, and incisive dead-ball delivery.',
            'phone' => '+212 662 987654',
        ]);

        // -------------------------------------------------------------
        // 2. Showcase Players (Matching Welcome Page Cards)
        // -------------------------------------------------------------
        $showcasePlayersData = [
            [
                'name' => 'Omar Hamdaoui',
                'email' => 'omar.hamdaoui@atlas11.com',
                'position' => 'Forward',
                'dob' => '2007-06-12',
                'location' => 'Rabat',
                'preferred_foot' => 'Right',
                'height' => 175,
                'weight' => 68,
                'current_club' => 'FUS Rabat Academy',
                'experience' => '4 seasons with FUS Rabat Youth Academy. Top scorer in the Botola Youth U-19 with 17 goals in 22 matches.',
                'bio' => 'Direct, electric winger with explosive acceleration, 1v1 take-on acumen, and pinpoint crossing delivery from wide channels.',
                'phone' => '+212 663 112233',
            ],
            [
                'name' => 'Soufiane Zekri',
                'email' => 'soufiane.zekri@atlas11.com',
                'position' => 'Defender',
                'dob' => '2005-09-24',
                'location' => 'Tangier',
                'preferred_foot' => 'Left',
                'height' => 188,
                'weight' => 82,
                'current_club' => 'IR Tanger Youth',
                'experience' => 'Starting center-back for IR Tanger U-21 squad. Regular training call-ups with the senior squad.',
                'bio' => 'Commanding left-footed center-back proficient in aerial duels, physical containment, and progressive ground passing from defensive thirds.',
                'phone' => '+212 664 445566',
            ],
            [
                'name' => 'Karim Benchekroun',
                'email' => 'karim.benchekroun@atlas11.com',
                'position' => 'Midfielder',
                'dob' => '2006-11-05',
                'location' => 'Marrakech',
                'preferred_foot' => 'Right',
                'height' => 181,
                'weight' => 74,
                'current_club' => 'KACM Youth',
                'experience' => 'Key engine of Kawkab Marrakech youth setup. 30 matches played in regional U-18 and national reserve cups.',
                'bio' => 'Box-to-box midfielder with high stamina, intercepting acumen, crisp bilateral distribution, and transition ball-carrying capabilities.',
                'phone' => '+212 665 778899',
            ],
        ];

        $playerProfiles = collect([$featuredPlayerProfile]);

        foreach ($showcasePlayersData as $data) {
            $u = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => 'password',
                'role' => User::ROLE_PLAYER,
                'email_verified_at' => now(),
            ]);

            $p = PlayerProfile::create([
                'user_id' => $u->id,
                'position' => $data['position'],
                'date_of_birth' => $data['dob'],
                'location' => $data['location'],
                'preferred_foot' => $data['preferred_foot'],
                'height' => $data['height'],
                'weight' => $data['weight'],
                'current_club' => $data['current_club'],
                'football_experience' => $data['experience'],
                'bio' => $data['bio'],
                'phone' => $data['phone'],
            ]);

            $playerProfiles->push($p);
        }

        // -------------------------------------------------------------
        // 3. Additional Moroccan Scouts (Clubs, Academies & Agencies)
        // -------------------------------------------------------------
        $scoutsData = [
            [
                'name' => 'Tariq Sektioui',
                'email' => 'tariq.fus@atlas11.com',
                'organization' => 'FUS Rabat Academy',
                'role_title' => 'Academy Technical Director',
                'location' => 'Rabat',
                'experience_years' => 15,
                'phone' => '+212 661 556677',
                'license_number' => 'CAF-PRO-2019',
                'bio' => 'Specializing in youth technical development and elite talent pathways for FUS Rabat Academy.',
            ],
            [
                'name' => 'Mehdi Lahlou',
                'email' => 'mehdi.wydad@atlas11.com',
                'organization' => 'Wydad Athletic Club',
                'role_title' => 'Chief Scout (First Team & Reserves)',
                'location' => 'Casablanca',
                'experience_years' => 10,
                'phone' => '+212 662 443322',
                'license_number' => 'FRMF-A-3401',
                'bio' => 'Overseeing domestic prospect scouting and regional tournament recruitment for Wydad AC.',
            ],
            [
                'name' => 'Hicham Dmiai',
                'email' => 'hicham.asfar@atlas11.com',
                'organization' => 'AS FAR Football Club',
                'role_title' => 'Senior Recruitment Coordinator',
                'location' => 'Rabat',
                'experience_years' => 8,
                'phone' => '+212 663 889900',
                'license_number' => 'FRMF-A-5120',
                'bio' => 'Focusing on athletic profile tracking and tactical transitions across Botola youth tiers.',
            ],
            [
                'name' => 'Mourad Batna',
                'email' => 'mourad.berkane@atlas11.com',
                'organization' => 'RS Berkane Academy',
                'role_title' => 'Eastern Region Head Scout',
                'location' => 'Berkane',
                'experience_years' => 6,
                'phone' => '+212 664 123789',
                'license_number' => 'FRMF-B-7714',
                'bio' => 'Leading youth scouting campaigns in the Oriental region, Oujda, and Nador regional divisions.',
            ],
            [
                'name' => 'Julien Marc',
                'email' => 'julien.marc@atlas11.com',
                'organization' => 'Atlas Stars Talent Agency',
                'role_title' => 'European Pathways Intermediary',
                'location' => 'Casablanca',
                'experience_years' => 9,
                'phone' => '+33 6 12 34 56 78',
                'license_number' => 'FIFA-INT-9932',
                'bio' => 'Connecting Moroccan top-flight prospects with European academy trials and development pathways.',
            ],
            [
                'name' => 'Carlos Mendez',
                'email' => 'carlos.mendez@atlas11.com',
                'organization' => 'La Liga Talent Network (MENA)',
                'role_title' => 'North Africa Regional Scout',
                'location' => 'Tangier',
                'experience_years' => 14,
                'phone' => '+34 600 123 456',
                'license_number' => 'RFEF-UEFA-PRO',
                'bio' => 'Scouting promising U-19 and U-21 talent across North Africa for Spanish professional clubs.',
            ],
        ];

        $scoutUsers = collect([$leadScoutUser]);

        foreach ($scoutsData as $sd) {
            $u = User::create([
                'name' => $sd['name'],
                'email' => $sd['email'],
                'password' => 'password',
                'role' => User::ROLE_SCOUT,
                'email_verified_at' => now(),
            ]);

            ScoutProfile::create([
                'user_id' => $u->id,
                'organization' => $sd['organization'],
                'role_title' => $sd['role_title'],
                'location' => $sd['location'],
                'experience_years' => $sd['experience_years'],
                'phone' => $sd['phone'],
                'license_number' => $sd['license_number'],
                'bio' => $sd['bio'],
            ]);

            $scoutUsers->push($u);
        }

        // -------------------------------------------------------------
        // 4. Comprehensive Moroccan Player Roster (24 additional talents)
        // -------------------------------------------------------------
        $rosterData = [
            // Goalkeepers
            [
                'name' => 'Taha Mourid',
                'email' => 'taha.mourid@atlas11.com',
                'position' => 'Goalkeeper',
                'dob' => '2005-03-14',
                'location' => 'Casablanca',
                'foot' => 'Right',
                'height' => 193,
                'weight' => 84,
                'club' => 'Wydad AC Youth',
                'experience' => 'Morocco U-20 international with 8 caps. Starting goalkeeper in national youth playoffs.',
                'bio' => 'Imposing goalkeeper with commanding box presence, lightning-quick reflex stops, and precise long distribution on counter-attacks.',
            ],
            [
                'name' => 'Ayoub Bouhaddouz',
                'email' => 'ayoub.bouhaddouz@atlas11.com',
                'position' => 'Goalkeeper',
                'dob' => '2006-08-22',
                'location' => 'Fes',
                'foot' => 'Right',
                'height' => 190,
                'weight' => 80,
                'club' => 'MAS Fes Academy',
                'experience' => '3 years with MAS Fes U-19. Clean sheet in 11 out of 19 appearances in regional division.',
                'bio' => 'Agile shot-stopper with great footwork, composed handling under aerial pressure, and proactive sweeping instincts.',
            ],
            [
                'name' => 'Bilal Soufiani',
                'email' => 'bilal.soufiani@atlas11.com',
                'position' => 'Goalkeeper',
                'dob' => '2007-01-19',
                'location' => 'Agadir',
                'foot' => 'Left',
                'height' => 189,
                'weight' => 78,
                'club' => 'Hassania Agadir Youth',
                'experience' => 'Selected for Southern Region regional all-star tournament two consecutive years.',
                'bio' => 'Rare left-footed modern sweeper-keeper capable of participating directly in defensive build-up play.',
            ],

            // Defenders
            [
                'name' => 'Mehdi Benabid',
                'email' => 'mehdi.benabid@atlas11.com',
                'position' => 'Defender',
                'dob' => '2005-05-30',
                'location' => 'Rabat',
                'foot' => 'Right',
                'height' => 186,
                'weight' => 79,
                'club' => 'Mohammed VI Football Academy',
                'experience' => 'Graduated through Mohammed VI Academy tier. Captain of Morocco U-18 selection.',
                'bio' => 'Tactically astute center-back with exceptional diagonal switches, recovery pace, and high interception percentage.',
            ],
            [
                'name' => 'Hamza Mendyl',
                'email' => 'hamza.mendyl@atlas11.com',
                'position' => 'Defender',
                'dob' => '2006-02-11',
                'location' => 'Kenitra',
                'foot' => 'Left',
                'height' => 176,
                'weight' => 70,
                'club' => 'KAC Kenitra Youth',
                'experience' => '2 seasons as starting left-back in amateur national division. 7 assists from overlapping runs.',
                'bio' => 'Attacking left full-back with relentless stamina, low center of gravity, and dangerous delivery into the penalty box.',
            ],
            [
                'name' => 'Walid El Wafi',
                'email' => 'walid.elwafi@atlas11.com',
                'position' => 'Defender',
                'dob' => '2005-12-03',
                'location' => 'Tetouan',
                'foot' => 'Right',
                'height' => 182,
                'weight' => 76,
                'club' => 'Moghreb Tetouan Youth',
                'experience' => 'Full season in Botola 2 reserve division, demonstrating adaptability at both right-back and right center-back.',
                'bio' => 'Tenacious, disciplined defender who excels in 1v1 ground duels and tracks back effectively on transitions.',
            ],
            [
                'name' => 'Chadi Amrani',
                'email' => 'chadi.amrani@atlas11.com',
                'position' => 'Defender',
                'dob' => '2007-04-09',
                'location' => 'Casablanca',
                'foot' => 'Right',
                'height' => 187,
                'weight' => 81,
                'club' => 'Raja CA Youth',
                'experience' => 'Regular starter for Raja U-19 national champion squad. Scored 4 headers off set pieces.',
                'bio' => 'Physical presence with outstanding aerial timing, aggressive front-foot defending, and leadership qualities.',
            ],
            [
                'name' => 'Nassim Chadli',
                'email' => 'nassim.chadli@atlas11.com',
                'position' => 'Defender',
                'dob' => '2006-07-28',
                'location' => 'Safi',
                'foot' => 'Right',
                'height' => 179,
                'weight' => 73,
                'club' => 'Olympic Safi Youth',
                'experience' => 'Regional youth cup winner with Olympic Safi. 28 official matches logged last term.',
                'bio' => 'Modern right wing-back with exceptional recovery speed, tidy passing under press, and defensive solidity.',
            ],
            [
                'name' => 'Marouane Sahraoui',
                'email' => 'marouane.sahraoui@atlas11.com',
                'position' => 'Defender',
                'dob' => '2005-10-17',
                'location' => 'Laayoune',
                'foot' => 'Both',
                'height' => 185,
                'weight' => 78,
                'club' => 'JS Massira Youth',
                'experience' => 'Southern provinces regional tournament MVP in 2024. Scouted by national youth directors.',
                'bio' => 'Ambidextrous defender capable of playing anywhere across the back line. Calm on the ball and strong in physical contests.',
            ],

            // Midfielders
            [
                'name' => 'Anas Zniti',
                'email' => 'anas.zniti@atlas11.com',
                'position' => 'Midfielder',
                'dob' => '2006-03-25',
                'location' => 'Fes',
                'foot' => 'Right',
                'height' => 183,
                'weight' => 76,
                'club' => 'Wydad de Fes Academy',
                'experience' => 'Holding midfielder with 40+ appearances across regional youth leagues. 88% pass accuracy rate.',
                'bio' => 'Shielding defensive midfielder (CDM) with high tactical awareness, pitch coverage, and composure in tight spaces.',
            ],
            [
                'name' => 'Zakaria Ouchen',
                'email' => 'zakaria.ouchen@atlas11.com',
                'position' => 'Midfielder',
                'dob' => '2007-09-14',
                'location' => 'Oujda',
                'foot' => 'Left',
                'height' => 177,
                'weight' => 71,
                'club' => 'Mouloudia Oujda Youth',
                'experience' => 'Standout central playmaker for MCO U-17. Registered 11 assists in regional competition.',
                'bio' => 'Silky left-footed playmaker with great technical touch, creative vision in the final third, and dead-ball prowess.',
            ],
            [
                'name' => 'Amine Bassi',
                'email' => 'amine.bassi@atlas11.com',
                'position' => 'Midfielder',
                'dob' => '2005-08-01',
                'location' => 'Rabat',
                'foot' => 'Right',
                'height' => 180,
                'weight' => 75,
                'club' => 'AS FAR Youth',
                'experience' => 'U-19 national champion with AS FAR. Training invite with Botola senior squad.',
                'bio' => 'Hard-working central midfielder with clean press-resistance, box-to-box engine, and powerful long-range shooting.',
            ],
            [
                'name' => 'Oussama El Karkouri',
                'email' => 'oussama.karkouri@atlas11.com',
                'position' => 'Midfielder',
                'dob' => '2006-12-20',
                'location' => 'Berkane',
                'foot' => 'Right',
                'height' => 174,
                'weight' => 67,
                'club' => 'RS Berkane Academy',
                'experience' => 'Featured in African Confederation Youth Invitational with RS Berkane.',
                'bio' => 'Nimble attacking midfielder who shines in half-spaces, combining quickly with forwards and unlocking deep blocks.',
            ],
            [
                'name' => 'Ismail Moutaraji',
                'email' => 'ismail.moutaraji@atlas11.com',
                'position' => 'Midfielder',
                'dob' => '2007-02-18',
                'location' => 'Casablanca',
                'foot' => 'Both',
                'height' => 178,
                'weight' => 72,
                'club' => 'Mohammed VI Football Academy',
                'experience' => 'Member of the national U-17 Moroccan pool. Participated in international youth tournaments in France.',
                'bio' => 'Technically gifted deep-lying playmaker capable of dictating the rhythm of games with pinpoint long and short passing.',
            ],
            [
                'name' => 'Youssef Belammari',
                'email' => 'youssef.belammari@atlas11.com',
                'position' => 'Midfielder',
                'dob' => '2005-11-12',
                'location' => 'Meknes',
                'foot' => 'Left',
                'height' => 176,
                'weight' => 69,
                'club' => 'COD Meknes Youth',
                'experience' => 'Key figure in CODM youth promotion campaign. 6 goals and 9 assists in 20 starts.',
                'bio' => 'Agile attacking midfielder with quick turns, visionary through-balls, and dangerous late arrivals into the box.',
            ],

            // Forwards
            [
                'name' => 'Ilyas Chouiar',
                'email' => 'ilyas.chouiar@atlas11.com',
                'position' => 'Forward',
                'dob' => '2006-05-17',
                'location' => 'Casablanca',
                'foot' => 'Right',
                'height' => 184,
                'weight' => 77,
                'club' => 'Wydad AC Youth',
                'experience' => 'Top scorer in the Casablanca regional youth league with 21 goals in 24 matches.',
                'bio' => 'Dynamic striker with sharp off-the-ball runs, clinical finishing inside the area, and good hold-up link play.',
            ],
            [
                'name' => 'Hamza Igamane',
                'email' => 'hamza.igamane@atlas11.com',
                'position' => 'Forward',
                'dob' => '2005-01-29',
                'location' => 'Rabat',
                'foot' => 'Right',
                'height' => 186,
                'weight' => 80,
                'club' => 'AS FAR Youth',
                'experience' => 'Morocco U-20 selection standout. 14 goals in national reserve competitions.',
                'bio' => 'Athletic, powerful number 9 who dominates center-backs physically, creates separation in the box, and finishes decisively.',
            ],
            [
                'name' => 'Moncef Bakkali',
                'email' => 'moncef.bakkali@atlas11.com',
                'position' => 'Forward',
                'dob' => '2007-08-10',
                'location' => 'Tangier',
                'foot' => 'Left',
                'height' => 173,
                'weight' => 66,
                'club' => 'IR Tanger Youth',
                'experience' => 'Northern regional MVP in 2025. Electric winger with 12 goals and 10 assists.',
                'bio' => 'Tricky, high-speed left-footed right winger who cuts inside onto his preferred foot with lethal bending strikes.',
            ],
            [
                'name' => 'Ayoub Nanah',
                'email' => 'ayoub.nanah@atlas11.com',
                'position' => 'Forward',
                'dob' => '2006-10-04',
                'location' => 'Marrakech',
                'foot' => 'Right',
                'height' => 178,
                'weight' => 72,
                'club' => 'KACM Youth',
                'experience' => '3 years with Kawkab Marrakech academy setup. Fast-track prospect for first team.',
                'bio' => 'Versatile forward comfortable as an inside-forward or second striker. High pressing rate and keen eye for goal.',
            ],
            [
                'name' => 'Salaheddine Benyoussef',
                'email' => 'salaheddine.benyoussef@atlas11.com',
                'position' => 'Forward',
                'dob' => '2005-06-15',
                'location' => 'Agadir',
                'foot' => 'Right',
                'height' => 182,
                'weight' => 75,
                'club' => 'Hassania Agadir Youth',
                'experience' => 'Lead striker for Hassania Agadir U-21. Scored in 5 consecutive matchdays.',
                'bio' => 'Intelligent target forward who combines physical strength with acute spatial awareness and accurate first-time strikes.',
            ],
            [
                'name' => 'Rayan Raveloson',
                'email' => 'rayan.raveloson@atlas11.com',
                'position' => 'Forward',
                'dob' => '2007-03-08',
                'location' => 'Mohammedia',
                'foot' => 'Both',
                'height' => 176,
                'weight' => 69,
                'club' => 'Chabab Mohammedia Youth',
                'experience' => 'Graduated through SCCM Academy. 15 appearances and 9 goals in regional youth cup.',
                'bio' => 'Explosive attacker who can play across all three frontline positions. Great agility, directness, and two-footed finishing.',
            ],
            [
                'name' => 'Adam Aznou',
                'email' => 'adam.aznou@atlas11.com',
                'position' => 'Defender',
                'dob' => '2006-06-02',
                'location' => 'Casablanca',
                'foot' => 'Left',
                'height' => 177,
                'weight' => 70,
                'club' => 'Mohammed VI Football Academy',
                'experience' => 'Considered one of the premier modern full-back prospects in the nation. Multiple youth international selections.',
                'bio' => 'Modern attack-minded left-back with world-class crossing accuracy, recovery pace, and high football IQ.',
            ],
            [
                'name' => 'Eliesse Ben Seghir',
                'email' => 'eliesse.benseghir@atlas11.com',
                'position' => 'Midfielder',
                'dob' => '2005-02-16',
                'location' => 'Rabat',
                'foot' => 'Right',
                'height' => 178,
                'weight' => 72,
                'club' => 'FUS Rabat Academy',
                'experience' => 'Standout attacking midfielder in Botola youth cups. Trial invitations from international academies.',
                'bio' => 'Silky dribbler with exceptional balance, deceptive body feints, and decisive through-passing under pressure.',
            ],
            [
                'name' => 'Reda Slimane',
                'email' => 'reda.slimane@atlas11.com',
                'position' => 'Forward',
                'dob' => '2006-09-09',
                'location' => 'Nador',
                'foot' => 'Right',
                'height' => 180,
                'weight' => 74,
                'club' => 'Fath Nador Youth',
                'experience' => 'Dominant attacking force in the Eastern regional championship with 18 goals in 20 matches.',
                'bio' => 'Direct winger with raw pace, aggressive pressing off the ball, and lethal ball-striking technique from distance.',
            ],
        ];

        foreach ($rosterData as $rd) {
            $u = User::create([
                'name' => $rd['name'],
                'email' => $rd['email'],
                'password' => 'password',
                'role' => User::ROLE_PLAYER,
                'email_verified_at' => now(),
            ]);

            $p = PlayerProfile::create([
                'user_id' => $u->id,
                'position' => $rd['position'],
                'date_of_birth' => $rd['dob'],
                'location' => $rd['location'],
                'preferred_foot' => $rd['foot'],
                'height' => $rd['height'],
                'weight' => $rd['weight'],
                'current_club' => $rd['club'],
                'football_experience' => $rd['experience'],
                'bio' => $rd['bio'],
                'phone' => '+212 6'.fake()->numerify('########'),
            ]);

            $playerProfiles->push($p);
        }

        // -------------------------------------------------------------
        // 5. Realistic Scouting Interests & Official Inquiries
        // -------------------------------------------------------------
        $scoutingInquiries = [
            // Inquiries directed to our featured demo player (Yassine El Idrissi)
            [
                'scout_email' => 'scout@atlas11.com',
                'player_profile' => $featuredPlayerProfile,
                'status' => ScoutingInterest::STATUS_CONTACTED,
                'message' => 'Outstanding performance during the U-19 regional tournament in Casablanca. Your passing vision and agility between lines fit the technical profile we are assembling for the national youth pool. We would like to invite you to an official assessment camp in Maâmoura next month.',
                'created_at' => now()->subDays(2),
            ],
            [
                'scout_email' => 'tariq.fus@atlas11.com',
                'player_profile' => $featuredPlayerProfile,
                'status' => ScoutingInterest::STATUS_VIEWED,
                'message' => 'Our technical staff at FUS Rabat Academy has followed your match footage over the last 6 fixtures. We are impressed by your tactical discipline and set-piece quality. We will have a scout attending your upcoming match against MAS Youth.',
                'created_at' => now()->subDays(5),
            ],
            [
                'scout_email' => 'carlos.mendez@atlas11.com',
                'player_profile' => $featuredPlayerProfile,
                'status' => ScoutingInterest::STATUS_PENDING,
                'message' => 'Monitoring attacking midfielders across the Moroccan Botola Youth for Spanish partner academy trials. Your ball carrying and transition numbers match our recruitment criteria. Please keep your contact details updated.',
                'created_at' => now()->subHours(18),
            ],

            // Inquiries sent by Lead Scout Karim Benjelloun (scout@atlas11.com) to other prospects
            [
                'scout_email' => 'scout@atlas11.com',
                'player_profile' => $playerProfiles->firstWhere('user.email', 'omar.hamdaoui@atlas11.com'),
                'status' => ScoutingInterest::STATUS_CONTACTED,
                'message' => 'Your scoring efficiency on the left wing for FUS Youth has caught our recruitment staff attention. We are considering you for the upcoming North African Youth Championship squad.',
                'created_at' => now()->subDays(3),
            ],
            [
                'scout_email' => 'scout@atlas11.com',
                'player_profile' => $playerProfiles->firstWhere('user.email', 'soufiane.zekri@atlas11.com'),
                'status' => ScoutingInterest::STATUS_VIEWED,
                'message' => 'Very solid defensive positioning in aerial duels. We will continue tracking your progress in the Botola 2 reserve division.',
                'created_at' => now()->subDays(7),
            ],
            [
                'scout_email' => 'scout@atlas11.com',
                'player_profile' => $playerProfiles->firstWhere('user.email', 'taha.mourid@atlas11.com'),
                'status' => ScoutingInterest::STATUS_PENDING,
                'message' => 'Evaluating U-20 goalkeepers with modern sweeping capabilities for the national youth pool. Excellent reflexes shown in the derby.',
                'created_at' => now()->subDays(1),
            ],
            [
                'scout_email' => 'scout@atlas11.com',
                'player_profile' => $playerProfiles->firstWhere('user.email', 'hamza.igamane@atlas11.com'),
                'status' => ScoutingInterest::STATUS_CONTACTED,
                'message' => 'Powerful physical display against Raja U-21. Our coaching staff would like to discuss official trial availability with your current representation.',
                'created_at' => now()->subDays(4),
            ],

            // Inquiries by other scouts across different players
            [
                'scout_email' => 'mehdi.wydad@atlas11.com',
                'player_profile' => $playerProfiles->firstWhere('user.email', 'karim.benchekroun@atlas11.com'),
                'status' => ScoutingInterest::STATUS_CONTACTED,
                'message' => 'Wydad Athletic Club is actively scouting dynamic box-to-box midfielders for our reserves setup. We would like to initiate contact regarding a trial session.',
                'created_at' => now()->subDays(6),
            ],
            [
                'scout_email' => 'hicham.asfar@atlas11.com',
                'player_profile' => $playerProfiles->firstWhere('user.email', 'mehdi.benabid@atlas11.com'),
                'status' => ScoutingInterest::STATUS_VIEWED,
                'message' => 'AS FAR recruitment is reviewing your defensive metrics. Exceptional recovery pace and aerial presence.',
                'created_at' => now()->subDays(8),
            ],
            [
                'scout_email' => 'mourad.berkane@atlas11.com',
                'player_profile' => $playerProfiles->firstWhere('user.email', 'zakaria.ouchen@atlas11.com'),
                'status' => ScoutingInterest::STATUS_PENDING,
                'message' => 'RS Berkane is closely monitoring talent from the Oriental region. Your playmaking displays in Oujda have been noted.',
                'created_at' => now()->subDays(2),
            ],
            [
                'scout_email' => 'julien.marc@atlas11.com',
                'player_profile' => $playerProfiles->firstWhere('user.email', 'moncef.bakkali@atlas11.com'),
                'status' => ScoutingInterest::STATUS_CONTACTED,
                'message' => 'Atlas Stars Agency represents elite Moroccan youth in European transitions. Your 1v1 speed makes you a strong candidate for Belgian and French youth showcase matches.',
                'created_at' => now()->subDays(4),
            ],
            [
                'scout_email' => 'carlos.mendez@atlas11.com',
                'player_profile' => $playerProfiles->firstWhere('user.email', 'adam.aznou@atlas11.com'),
                'status' => ScoutingInterest::STATUS_CONTACTED,
                'message' => 'La Liga Talent Network assessment: elite profile for modern left full-back position. We would like to schedule a virtual meeting with your academy director.',
                'created_at' => now()->subDays(3),
            ],
            [
                'scout_email' => 'tariq.fus@atlas11.com',
                'player_profile' => $playerProfiles->firstWhere('user.email', 'ilyas.chouiar@atlas11.com'),
                'status' => ScoutingInterest::STATUS_CLOSED,
                'message' => 'Assessment concluded following the youth cup fixtures. Candidate profile archived for future intake windows.',
                'created_at' => now()->subDays(12),
            ],
        ];

        foreach ($scoutingInquiries as $inquiry) {
            $scout = $scoutUsers->firstWhere('email', $inquiry['scout_email']);
            $profile = $inquiry['player_profile'];

            if (! $scout || ! $profile) {
                continue;
            }

            // Ensure unique pair constraint
            $existing = ScoutingInterest::where('scout_id', $scout->id)
                ->where('player_profile_id', $profile->id)
                ->first();

            if ($existing) {
                continue;
            }

            $interest = ScoutingInterest::create([
                'scout_id' => $scout->id,
                'player_profile_id' => $profile->id,
                'status' => $inquiry['status'],
                'message' => $inquiry['message'],
                'created_at' => $inquiry['created_at'],
                'updated_at' => $inquiry['created_at'],
            ]);

            // Dispatch realistic database notification to the player
            $playerUser = $profile->user;
            if ($playerUser) {
                $playerUser->notify(new ScoutingInterestReceived($interest));
            }
        }

        // -------------------------------------------------------------
        // 6. Manage Notification Read / Unread Statuses for Demo User
        // -------------------------------------------------------------
        // Leave 1 notification unread and mark the others as read for realistic demo dashboard counters
        $demoNotifications = $featuredPlayerUser->notifications()->get();
        if ($demoNotifications->count() > 1) {
            $demoNotifications->skip(1)->each(fn ($n) => $n->markAsRead());
        }
    }
}
