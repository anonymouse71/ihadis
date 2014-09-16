<?php

namespace Ihadis\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class SectionController extends Controller
{
    protected function prepareResource(Request $request, $resource)
    {
        if ($request->attributes->has('chapter')) {
            $chapter = $this->get('ihadis.repository.chapter')->find($request->attributes->get('chapter'));
            if ($chapter) {
                $resource->setChapter($chapter);
                $resource->setBook($chapter->getBook());
            }
        }
    }

    protected function finalizeResource(Request $request, $resource)
    {
        // Clear translations if body is empty
        $params = $request->request->all();
        if(empty($params['ihadis_section']['titleEnglish'])) {
            $resource->getNewTranslations()->remove('en');
        }
        if(empty($params['ihadis_section']['titleArabic'])) {
            $resource->getNewTranslations()->remove('ar');
        }
    }
}