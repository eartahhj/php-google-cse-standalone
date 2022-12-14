<?php
namespace CodingHouse\GoogleCSE;

class GoogleCustomSearchEngine
{
    protected $cseId = ''; # CSE unique ID from Google Search Console
    protected $apiKey = ''; # CSE API Key from Google Cloud Console
    protected $queryHttpParam='q';
    protected $start = 0; # Which page to start from
    protected $query = '';
    protected $resultsPerPage = 10;
    protected $url = '';
    protected $json = '';
    protected $normalResults = [];
    protected $promotedResults = [];
    protected $data = '';
    protected $selectedPage = 1;
    protected $message = '';
    protected $language = '';
    protected $languages = ['it'=>'Italiano','en'=>'English','es'=>'','de'=>'','fr'=>'','ru'=>''];
    protected $strings = [];
    protected $totalResults = 0;
    protected $submitName = 'send';
    protected $requestData = ''; # From JSON data->queries
    protected $searchInfo = ''; # Example: search time, total results, etc.
    protected $sort = '';

    private function setStart()
    {
        $start = 0;

        if (!empty($_GET) and isset($_GET['start']) and intval($_GET['start'])) {
            $start = intval($_GET['start']);
        }

        if ($start < 0) {
            $start = 0;
        } elseif ($start > 90) {
            $start = 90; # Max 90 results (10th page)
        }
        $this->start = $start;
    }

    public static function getSearchEngineIdByLanguage(string $language, array $searchEngineIdsMultilanguage): string
    {
        return $searchEngineIdsMultilanguage[$language] ?? '';
    }

    public function renderPager()
    {
        if ($this->totalResults > 10) {
            $numberOfPages = intval(ceil($this->totalResults / 10));
        } else {
            $numberOfPages = 1;
        }
        if ($numberOfPages > 10) {
            $numberOfPages = 10;
        }
        if ($numberOfPages > 1) { # No need for pager with only 1 page
            include __DIR__ . '/html/pager.php';
        }
    }

    public function renderPromoResults($cssClass = 'result result-promo')
    {
        $totalPromotedResults = 0;

        if (isset($this->promotedResults) and count($this->promotedResults) > 0) {
            $totalPromotedResults = count($this->promotedResults);

            include __DIR__ . '/html/promoted-results.php';
        }

    }

    public function renderNormalResults($cssClass='result')
    {
        if (isset($this->normalResults) and $this->totalResults > 0) {
            include __DIR__ . '/html/normal-results.php';
        }
    }

    public function setSort(string $sort)
    {
        $this->sort = $sort;
        return;
    }

    public function getSort() : string
    {
        return $this->sort;
    }

    public function __construct(string $cseId, string $apiKey, string $language = '')
    {
        $this->cseId = $cseId;
        $this->apiKey = $apiKey;
        if ($language and isset($this->languages[$language])) {
            $this->language = $language;
        } else {
            $this->language = reset($this->languages);
        }
    }

    public function setResultsPerPage($resultsPerPage)
    {
        if (intval($resultsPerPage) >= 0) {
            $this->resultsPerPage = $resultsPerPage;
        } else {
            $this->resultsPerPage = 10;
        }
        if ($this->resultsPerPage > 50) {
            $this->resultsPerPage = 50;
        }
    }

    public function setQueryHttpParam($param)
    {
        $this->queryHttpParam = htmlspecialchars($param);
    }

    public function setSubmitName($name)
    {
        $this->submitName = htmlspecialchars($name);
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function renderForm(string $id = 'googlecse-form-search', string $cssClass = 'googlecse-form-search', string $action = '', string $method = 'get') : void
    {
        if ($action == '') {
            $action = $_SERVER['REQUEST_URI'];
        }

        include __DIR__ . '/html/form.php';

        return;
    }

    public function initEngine() : void
    {
        $this->setStart();

        if (isset($_GET) and isset($_GET[$this->queryHttpParam]) and $_GET[$this->queryHttpParam]) {
            $this->query = trim($_GET[$this->queryHttpParam]);
        }

        if ($this->query != '') {
            $this->url = 'https://www.googleapis.com/customsearch/v1?q=' . ($this->query ? urlencode($this->query) : '') . '&num=' . $this->resultsPerPage;
            $this->url .= '&start=' . ($this->start ? $this->start : 1) . '&cx=' . $this->cseId . '&key=' . $this->apiKey . '&filter=1';

            if ($this->sort) {
                $this->url .= '&sort=' . urlencode($this->sort);
            }

            $this->selectedPage = intval(floor($this->start / 10) + 1);
            $this->json = file_get_contents($this->url);

            if ($this->json) {
                # JSON search results provided by Google's Custom Search API
                $this->data = json_decode($this->json);
            }

            if ($this->data->queries) {
                $this->requestData = $this->data->queries;
            }

            $this->searchInfo = $this->data->searchInformation ?? '';

            $this->normalResults = $this->data->items ?? [];

            $this->promotedResults = $this->data->promotions ?? [];


            if (intval($this->searchInfo->totalResults) > 0) {
                $this->totalResults = intval($this->searchInfo->totalResults);
            }

            if (!empty($this->promotedResults)) {
                $this->totalResults += count($this->promotedResults);
            }
        }

        return;
    }

    public function html()
    {
        if (isset($_REQUEST[$this->submitName])) {
            include __DIR__ . '/html/default.php';
        }
    }
}
