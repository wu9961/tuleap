/*
 * Copyright (c) Enalean, 2020 - present. All Rights Reserved.
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

import { shallowMount } from "@vue/test-utils";
import TestDefinitionCard from "./TestDefinitionCard.vue";
import { BacklogItem, TestDefinition } from "../../../type";
import { createStoreMock } from "../../../../../../../../src/scripts/vue-components/store-wrapper-jest";
import { RootState } from "../../../store/type";

jest.useFakeTimers();

describe("TestDefinitionCard", () => {
    it("Display a test definition as a card", () => {
        const wrapper = shallowMount(TestDefinitionCard, {
            propsData: {
                test_definition: {
                    id: 123,
                    short_type: "test_def",
                    summary: "Test definition summary",
                    test_status: "notrun",
                } as TestDefinition,
                backlog_item: { id: 456 } as BacklogItem,
            },
        });

        expect(wrapper.element).toMatchSnapshot();
    });

    it("Display an icon for automated tests", () => {
        const wrapper = shallowMount(TestDefinitionCard, {
            propsData: {
                test_definition: {
                    id: 123,
                    short_type: "test_def",
                    summary: "Test definition summary",
                    automated_tests: "Automated test name",
                } as TestDefinition,
                backlog_item: { id: 456 } as BacklogItem,
            },
        });

        expect(wrapper.find("[data-test=automated-test-icon]").exists()).toBe(true);
    });

    it("Displays an icon for passed test", () => {
        const wrapper = shallowMount(TestDefinitionCard, {
            propsData: {
                test_definition: {
                    id: 123,
                    short_type: "test_def",
                    summary: "Test definition summary",
                    test_status: "passed",
                } as TestDefinition,
                backlog_item: { id: 456 } as BacklogItem,
            },
        });

        expect(wrapper.find("[data-test=test-status-icon]").classes("fa-check-circle")).toBe(true);
    });

    it("Displays an icon for failed test", () => {
        const wrapper = shallowMount(TestDefinitionCard, {
            propsData: {
                test_definition: {
                    id: 123,
                    short_type: "test_def",
                    summary: "Test definition summary",
                    test_status: "failed",
                } as TestDefinition,
                backlog_item: { id: 456 } as BacklogItem,
            },
        });

        expect(wrapper.find("[data-test=test-status-icon]").classes("fa-times-circle")).toBe(true);
    });

    it("Displays an icon for blocked test", () => {
        const wrapper = shallowMount(TestDefinitionCard, {
            propsData: {
                test_definition: {
                    id: 123,
                    short_type: "test_def",
                    summary: "Test definition summary",
                    test_status: "blocked",
                } as TestDefinition,
                backlog_item: { id: 456 } as BacklogItem,
            },
        });

        expect(wrapper.find("[data-test=test-status-icon]").classes("fa-exclamation-circle")).toBe(
            true
        );
    });

    it("Displays an icon for notrun test", () => {
        const wrapper = shallowMount(TestDefinitionCard, {
            propsData: {
                test_definition: {
                    id: 123,
                    short_type: "test_def",
                    summary: "Test definition summary",
                    test_status: "notrun",
                } as TestDefinition,
                backlog_item: { id: 456 } as BacklogItem,
            },
        });

        expect(wrapper.find("[data-test=test-status-icon]").classes("fa-question-circle")).toBe(
            true
        );
    });

    it("Does not display a status icon for a test that has not been planned in a campaign yet", () => {
        const wrapper = shallowMount(TestDefinitionCard, {
            propsData: {
                test_definition: {
                    id: 123,
                    short_type: "test_def",
                    summary: "Test definition summary",
                    test_status: null,
                } as TestDefinition,
                backlog_item: { id: 456 } as BacklogItem,
            },
        });

        expect(wrapper.find("[data-test=test-status-icon]").exists()).toBe(false);
    });

    it("Marks the test as just refreshed", () => {
        const $store = createStoreMock({
            state: {
                backlog_item: {},
            } as RootState,
        });
        const wrapper = shallowMount(TestDefinitionCard, {
            propsData: {
                test_definition: {
                    id: 123,
                    is_just_refreshed: true,
                } as TestDefinition,
                backlog_item: { id: 456 } as BacklogItem,
            },
            mocks: { $store },
        });

        expect(wrapper.classes("test-plan-test-definition-is-just-refreshed")).toBe(true);

        jest.advanceTimersByTime(1000);

        expect($store.commit).toHaveBeenCalledWith(
            "backlog_item/removeIsJustRefreshedFlagOnTestDefinition",
            {
                backlog_item: { id: 456 },
                test_definition: { id: 123, is_just_refreshed: true },
            }
        );
    });
});
