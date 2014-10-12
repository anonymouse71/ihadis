<?php

namespace Ihadis\Bundle\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class ChapterController extends Controller
{
    protected function prepareResource(Request $request, $resource)
    {
        if ($request->attributes->has('book')) {
            $book = $this->get('ihadis.repository.book')->find($request->attributes->get('book'));
            if ($book) {
                $resource->setBook($book);
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