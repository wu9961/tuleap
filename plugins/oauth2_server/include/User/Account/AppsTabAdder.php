<?php
/**
 * Copyright (c) Enalean, 2020-Present. All Rights Reserved.
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

namespace Tuleap\OAuth2Server\User\Account;

use Tuleap\User\Account\AccountTabPresenter;
use Tuleap\User\Account\AccountTabPresenterCollection;

final class AppsTabAdder
{
    public function addTabs(AccountTabPresenterCollection $collection): void
    {
        $collection->add(
            new AccountTabPresenter(
                dgettext('tuleap-oauth2_server', 'OAuth2 Apps'),
                AccountAppsController::URL,
                'fa-cubes',
                $collection->getCurrentHref()
            )
        );
    }
}