<!--
  - Copyright (c) Enalean, 2018. All Rights Reserved.
  -
  - This file is a part of Tuleap.
  -
  - Tuleap is free software; you can redistribute it and/or modify
  - it under the terms of the GNU General Public License as published by
  - the Free Software Foundation; either version 2 of the License, or
  - (at your option) any later version.
  -
  - Tuleap is distributed in the hope that it will be useful,
  - but WITHOUT ANY WARRANTY; without even the implied warranty of
  - MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  - GNU General Public License for more details.
  -
  - You should have received a copy of the GNU General Public License
  - along with Tuleap. If not, see <http://www.gnu.org/licenses/>.
  -->

<template>
    <form class="timetracking-writing-mode">
        <div class="timetracking-writing-mode-selected-dates">
            <div class="tlp-form-element timetracking-writing-mode-selected-date">
                <label for="timetracking-start-date" class="tlp-label">
                    <translate>From</translate>
                    <i class="fa fa-asterisk"></i>
                </label>
                <div class="tlp-form-element tlp-form-element-prepend">
                    <span class="tlp-prepend"><i class="fa fa-calendar"></i></span>
                    <input
                        type="text"
                        class="tlp-input tlp-input-date"
                        id="timetracking-start-date"
                        ref="start_date"
                        v-model="start_date"
                        size="11"
                        data-test="timetracking-start-date"
                    />
                </div>
            </div>

            <div class="tlp-form-element timetracking-writing-mode-selected-date">
                <label for="timetracking-end-date" class="tlp-label">
                    <translate>To</translate>
                    <i class="fa fa-asterisk"></i>
                </label>
                <div class="tlp-form-element tlp-form-element-prepend">
                    <span class="tlp-prepend"><i class="fa fa-calendar"></i></span>
                    <input
                        type="text"
                        class="tlp-input tlp-input-date"
                        id="timetracking-end-date"
                        ref="end_date"
                        v-model="end_date"
                        size="11"
                        data-test="timetracking-end-date"
                    />
                </div>
            </div>
        </div>
        <div class="timetracking-writing-mode-actions">
            <button
                class="tlp-button-primary tlp-button-outline"
                type="button"
                v-on:click="toggleReadingMode()"
                v-translate
            >
                Cancel
            </button>
            <button
                class="tlp-button-primary timetracking-writing-search"
                type="button"
                data-test="timetracking-search-for-dates"
                v-on:click="changeDates"
                v-translate
            >
                Search
            </button>
        </div>
    </form>
</template>
<script>
import { datePicker } from "tlp";
import { mapState, mapMutations, mapActions } from "vuex";

export default {
    name: "WidgetWritingMode",

    computed: {
        ...mapState(["start_date", "end_date"]),
    },
    mounted() {
        [this.$refs.start_date, this.$refs.end_date].forEach((element) => datePicker(element));
    },
    methods: {
        ...mapMutations(["toggleReadingMode"]),
        ...mapActions(["setDatesAndReload"]),
        changeDates() {
            this.setDatesAndReload([this.$refs.start_date.value, this.$refs.end_date.value]);
        },
    },
};
</script>
