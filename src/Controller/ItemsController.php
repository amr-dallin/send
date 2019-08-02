<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 *
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $items = $this->Items->find('result', [
            'category_ids' => $this->request->getData('Categories.id')
        ])->toArray();

        $this->set('items', $items);
    }

    public function domain()
    {
        $items = $this->Items
            ->find('firstStageValid')
            ->where(['Items.domain_id IS' => null]);

        foreach($items as $item) {
            list($lcl, $dmn) = explode('@', $item->email);

            $domain = $this->Items->Domains
                ->find()
                ->where(['Domains.domain' => $dmn])
                ->first();

            if (empty($domain)) {
                $domain = $this->Items->Domains->newEntity();
                $domain->domain = $dmn;

                $this->Items->Domains->save($domain);
            }

            $item->domain_id = $domain->id;
            $this->Items->save($item);
        }

        exit;
    }

    public function fix()
    {
        $itemsGroup = $this->Items
            ->find()
            ->select([
                'Items.slug',
                'quantity' => 'COUNT(*)'
            ])
            ->group(['Items.slug'])
            ->having(['quantity >' => 1])
            ->order(['quantity' => 'DESC']);

        echo '<h1>Список компаний, сгруппированных под единым брендом, с общим URL.</h1>';
        echo '<p style="border: 1px solid red; padding: 5px;">На примере бренда «LEGION СЕТЬ МАГАЗИНОВ» (первый в списке), при клике на гиперссылку магазина компании по адресу <i>«Узбекистан, Бухарская область, Бухара, шоссе ГАЗЛИЙСКОЕ, 1 А»</i>, открывается описание магазина по адресу <i>«Узбекистан, Ташкент, МИРАБАДСКИЙ РАЙОН, ул. ФИДОКОР, 7/7 А»</i>.</p>';
        echo '<p style="color: red;">В списке присутствуют возможные дубли (помечены красным цветом).</p>';
        echo '<p style="font-size: 18px;"><strong>Данные актуальны на 30 июля 2019 года.</strong></p><br/>';
        $i = 1;
        foreach($itemsGroup as $itemGroup) {
            $items = $this->Items
                ->find()
                ->where(['Items.slug' => $itemGroup->slug])
                ->contain('ItemTelephones')
                ->toArray();

            if (empty($items)) {
                continue;
            }

            echo '<h2>############## №' . $i . ' ##############</h2>';

            if (in_array($itemGroup->slug, ['kontakt-linzalar-ooo-1', 'samarkandskoe-oblastnoe-ob\'edinenie-profsoyuznyh-organizacij-sovet-federacii-profsoyuzov-uzbekistana-1'])) {
                echo '<p style="color: red;">ВОЗМОЖНО, ДУБЛЬ</p>';
            }

            foreach($items as $item) {
                echo '<strong>Юридическое название:</strong> ' . $item->legal_name . '<br/>';
                echo '<strong>Брендовое название:</strong> ' . $item->brand_name . '<br/>';
                echo '<strong>Адрес:</strong> ' . $item->address . '<br/>';
                echo '---------------------------------<br/>';
            }

            echo '<br/>Общий URL - ' . YP . 'kompaniya' . DS . $itemGroup->slug . '<br/><br/>';
            echo '#####################################################################################################<br/><br/>';

            $i++;
        }

        exit;
    }
}
