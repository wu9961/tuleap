<?php
/**
 * Copyright (c) Enalean, 2020 - Present. All Rights Reserved.
 *
 * This file is a part of Tuleap.
 *
 * Tuleap is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * Tuleap is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace Tuleap\TestPlan\TestDefinition;

use Codendi_Request;
use Response;
use Tracker_Artifact_Redirect;
use Tracker_ArtifactFactory;

class RedirectParameterInjector
{
    public const TTM_BACKLOG_ITEM_ID_KEY = 'ttm_backlog_item_id';
    public const TTM_MILESTONE_ID_KEY    = 'ttm_milestone_id';

    /**
     * @var Tracker_ArtifactFactory
     */
    private $artifact_factory;
    /**
     * @var Response
     */
    private $response;

    public function __construct(Tracker_ArtifactFactory $artifact_factory, Response $response)
    {
        $this->artifact_factory = $artifact_factory;
        $this->response         = $response;
    }

    public function injectAndInformUserAboutBacklogItemBeingCovered(
        Codendi_Request $request,
        Tracker_Artifact_Redirect $redirect
    ): void {
        $ttm_backlog_item_id = $request->get(self::TTM_BACKLOG_ITEM_ID_KEY);
        $ttm_milestone_id    = $request->get(self::TTM_MILESTONE_ID_KEY);
        if (! $ttm_backlog_item_id || ! $ttm_milestone_id) {
            return;
        }

        $backlog_item = $this->artifact_factory->getArtifactByIdUserCanView(
            $request->getCurrentUser(),
            $ttm_backlog_item_id
        );
        if (! $backlog_item) {
            return;
        }

        $this->response->addFeedback(
            \Feedback::INFO,
            sprintf(
                dgettext('tuleap-testplan', 'You are creating a new test that will cover: %s'),
                $backlog_item->getXRefAndTitle()
            ),
            CODENDI_PURIFIER_FULL
        );

        $this->injectParameters($redirect, $ttm_backlog_item_id, $ttm_milestone_id);
    }

    public function injectParameters(Tracker_Artifact_Redirect $redirect, string $ttm_backlog_item_id, string $ttm_milestone_id): void
    {
        $redirect->query_parameters[RedirectParameterInjector::TTM_BACKLOG_ITEM_ID_KEY] = $ttm_backlog_item_id;
        $redirect->query_parameters[RedirectParameterInjector::TTM_MILESTONE_ID_KEY]    = $ttm_milestone_id;
    }
}
