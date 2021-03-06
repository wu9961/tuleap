<?php
/**
 * Copyright (c) Enalean, 2020 - present. All Rights Reserved.
 *
 *  This file is a part of Tuleap.
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
 *
 */
declare(strict_types=1);

namespace Tuleap\Project\Event;

use Project;
use Tuleap\Event\Dispatchable;

class ReferencesGroupCreatorPostProjectCreation implements Dispatchable
{
    public const NAME = 'references_group_creator_post_project_creation';

    /**
     * @var string
     */
    private $short_name;
    /**
     * @var int
     */
    private $project_id;

    public function __construct(string $short_name, Project $project)
    {
        $this->short_name = $short_name;
        $this->project_id = (int) $project->getID();
    }

    public function getProjectId(): int
    {
        return $this->project_id;
    }

    public function getShortName(): string
    {
        return $this->short_name;
    }
}
