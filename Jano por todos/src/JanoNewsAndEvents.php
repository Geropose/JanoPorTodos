<?php
namespace Jano;

class JanoNewsAndEvents
{
    const FilterTandil='tandil';
    const FilterJuarez='juarez';
    const FilterNext='next';

    protected $events;
    protected $latestNews;

    /**
     * @param string|int $facebookPostId
     * @param string|array $filter one of the Filter const or an array of any of them [FilterTandil, FilterJuarez, FilterNext]
     * @return void
     */
    public function addEvent($facebookPostId,$filter) {
        if(is_array($filter)) $filter = implode(' ',$filter);
        $this->events[$facebookPostId] = $filter;
    }
    /**
     * events object should have the facebook postId as key and type class(es) as value
    types for filter: 'tandil', 'juarez', 'next'
     * @return array
     */
    public function getEvents() {
        return $this->events;
    }

    /**
     * @return mixed
     */
    public function getLatestNews()
    {
        return $this->latestNews;
    }

    public function addLatestNews($facebookPostId) {
        $this->latestNews[] = $facebookPostId;
    }


}