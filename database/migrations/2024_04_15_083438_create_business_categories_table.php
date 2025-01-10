<?php

use App\BusinessCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (config('fms.type') !== 'work') {
            return;
        }

        Schema::create('business_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $categories = [
            'Andra företagsservicefirmor',
            'Annan serviceverksamhet',
            'Banker och andra kreditinstitut',
            'Beklädnads- och pälsindustri',
            'Bilhandel och -verkstäder, bensinstationer',
            'Byggindustri',
            'Datakonsulter och dataservicebyråer',
            'Detaljhandel',
            'El-, gas-, värmeförsörjning',
            'Elektroindustri',
            'Fastighetsbolag och fastighetsförvaltare',
            'Fiske',
            'Flygbolag',
            'Forskning och utveckling',
            'Förlag, grafisk- och reproduktionsindustri',
            'Försäkringsbolag',
            'Förvärvsarbete i hushåll',
            'Gummi- och plastindustri',
            'Hotell- och restaurangverksamhet',
            'Hälso- och sjukvård, veterinärverksamhet',
            'Instrument-, foto-, optik- och urindustri',
            'Intresseorganisationer',
            'Jordbruk och jakt',
            'Kemisk industri',
            'Kontorsmaskin- och datorindustri',
            'Landtransportföretag',
            'Livsmedels-, dryckesindustri',
            'Läder- och lädervaruindustri',
            'Maskinindustri',
            'Massa-, pappers- och pappersvaruindustri',
            'Metallmalmsgruvor',
            'Metallvaruindustri',
            'Mineralutvinningsindustri, annan',
            'Motor- och släpfordonsindustri',
            'Möbelindustri samt annan tillverkningsindustri',
            'Offentlig förvaltning och försvar',
            'Parti- och agenturhandel',
            'Post- och telekommunikation',
            'Rederier',
            'Rekreation, kultur och sport',
            'Religiösa samfund',
            'Reningsverk, avfallsanläggningar, renhållning',
            'Resebyråverksamhet, transportförmedling',
            'Skogsbruk',
            'Sociala tjänster',
            'Sten-, ler- och glasindustri',
            'Stål- och metallverk',
            'Teleproduktindustri',
            'Textilindustri',
            'Tobaksindustri',
            'Transportmedelsindustri, övrig',
            'Trävaruindustri',
            'Utbildning',
            'Uthyrningsfirmor',
            'Vattenförsörjning',
            'Verksamhet vid internationella organisationer',
            'Återvinningsindustri',
        ];

        foreach ($categories as $category) {
            BusinessCategory::create([
                'name' => $category,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('business_categories');
    }
};
