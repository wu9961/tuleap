<?php
/**
 * Copyright (c) Enalean, 2014. All Rights Reserved.
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

namespace Tuleap\Trafficlights;

class IndexController extends TrafficlightsController {

    public function index() {
        return $this->renderToString(
            'index',
            new IndexPresenter(
                $this->project->getId(),
                $this->config->getCampaignTrackerId($this->project),
                $this->config->getTestDefinitionTrackerId($this->project),
                $this->config->getTestExecutionTrackerId($this->project),
                $this->config->getIssueTrackerId($this->project),
                $this->userCanLinkIssues(),
                $this->request->getCurrentUser(),
                $this->current_milestone
            )
        );
    }

    public function userCanLinkIssues()
    {
        $issue_tracker_id = $this->config->getIssueTrackerId($this->project);
        $issue_tracker    = $this->tracker_factory->getTrackerById($issue_tracker_id);

        return (! empty($issue_tracker)) &&
            $issue_tracker->userCanSubmitArtifact($this->request->getCurrentUser());
    }
}
