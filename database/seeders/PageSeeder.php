<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Home',
                'url' => 'home',
                'content' => '
                <p>
                Al jaren is De Gouden Draak een begrip als het gaat om de beste afhaalgerechten in &apos;s-Hertogenbosch.<br>
                Graag trakteren we u op authentieke gerechten uit de Cantonese keuken.
                </p>
                <br>
                <h1 class="home"><u>Speciale Studentenaanbieding</u></h1>
                <h2>Chinese Rijsttafel (2 personen)</h2>
                <table>
                <tr><th class="table" colspan="2">Maak een keuze uit 3 van onderstaande keuzegerechten:</th></tr>
                    <tr>
                        <td class="td-left">Koe Loe Yuk</td>
                        <td class="td-right">Foe Yong Hai</td>
                    </tr>
                    <tr>
                        <td class="td-left">Tjap Tjoy</td>
                        <td class="td-right">Garnalen met Gebakken Knoflooksaus</td>
                    </tr>
                    <tr>
                        <td class="td-left">Babi Pangang</td>
                        <td class="td-right">Kipfilet in Zwarte Bonen Saus</td>
                    </tr>
                    <tr>
                        <td colspan="2">Met witte rijst. (Nasi of bami voor meerprijs mogelijk.)</td>
                    </tr>
                    <tr>
                        <td class="price" colspan="2">Prijs: &euro;21,00</td>
                    </tr>
                </table>
                ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Contact',
                'url' => 'contact',
                'content' => '<p class="contact">
                               De Gouden Draak is eenvoudig te vinden, vlak bij het centrum, 5 minuten lopen achter het centraal station.
                               <br>
                               <br>
                               Onderwijsboulevard 215, kamer OG112
                               <br>
                               5223 DE &apos;s-Hertogenbosch
</p>
                             ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Nieuws',
                'url' => 'news',
                'content' => '<p>
                                Door de Corona crisis is De Gouden Draak op het moment slechts beperkt open.
                                <br />
                                Het restaurant-gedeelte is gesloten. U kan uw favoriete gerechten nog wel afhalen.
                              </p>',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($pages as $page) {
            \App\Models\Page::updateOrInsert($page);
        }
    }
}
