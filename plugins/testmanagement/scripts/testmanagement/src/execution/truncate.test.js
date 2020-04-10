/*
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

import { truncateHTML } from "./truncate";

describe("truncateHTML", () => {
    it(`Given the content is smaller than expected length,
        Then it does not add an ellipsis`, () => {
        expect(truncateHTML("<p>Hello World</p>", 888)).toBe("<p>Hello World</p>");
    });

    it(`Given the content is bigger than expected length,
        Then it adds an ellipsis`, () => {
        expect(truncateHTML("<p>Hello World</p>", 8)).toBe("<p>Hello Wo…</p>");
    });

    it(`Given the content is bigger than expected length,
        And it contains additional content,
        Then it adds an ellipsis and remove the remaining content`, () => {
        expect(
            truncateHTML("<p>Hello World <strong>!</strong></p><p>to be also removed</p>", 8)
        ).toBe("<p>Hello Wo…</p>");
    });

    it(`Given the text to cut is nested in sub tags
        Then it adds an ellipsis inside those tags`, () => {
        expect(truncateHTML("<p>Hello <strong>World</strong></p>", 8)).toBe(
            "<p>Hello <strong>Wo…</strong></p>"
        );
    });

    it(`Given the text is plain text
        Then it adds an ellipsis without adding tags`, () => {
        expect(truncateHTML("Hello World", 8)).toBe("Hello Wo…");
    });
});