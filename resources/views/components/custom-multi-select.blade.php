<select x-cloak {{ $attributes }} style="display: none">
    <option value="">{{ $attributes['placeholder'] }}</option>
    @php
        $index = 0;
    @endphp
    @foreach ($options as $key => $item)
        <option @if(isset($ids[$index])) data-id="{{ $ids[$index] }}" @endif @if($key == $value) {{ 'selected' }} @endif value="{{ $key }}">{{ __($item) }}</option>
        @php
            $index++;
        @endphp
    @endforeach
</select>

<div x-data="dropdown()" x-init="loadOptions()" class="w-full flex flex-col items-center h-auto mx-auto" id="{{ $attributes['id'] }}_dropdown">
    <form>
        <input name="{{ $attributes['id'] }}_values" id="{{ $attributes['id'] }}_values" type="hidden" x-bind:value="selectedValues()">
        <div class="inline-block relative w-full">
            <div class="flex flex-col items-center relative">
                <div x-on:click="open" class="w-full  svelte-1l8159u">
                    <div class="focus:outline-none focus:shadow-outline mt-1 flex border border-gray-200 bg-white rounded svelte-1l8159u"
                        style="background: #FBFBFB 0% 0% no-repeat padding-box;
                        border: 1px solid #C4C4C4;
                        border-radius: 0.375rem;">
                        <div class="flex flex-auto flex-wrap">
                            <template x-for="(option,index) in selected" :key="options[option].value">
                                <div class="flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full text-teal-700 bg-teal-100 border border-teal-300 ">
                                    <div class="text-xs font-normal leading-none max-w-full flex-initial x-model="
                                        options[option]" x-text="options[option].text"></div>
                                    <div class="flex flex-auto flex-row-reverse">
                                        <div x-on:click="remove(index,option)">
                                            <svg class="fill-current h-6 w-6 " role="button" viewBox="0 0 20 20">
                                                <path d="M14.348,14.849c-0.469,0.469-1.229,0.469-1.697,0L10,11.819l-2.651,3.029c-0.469,0.469-1.229,0.469-1.697,0
                                           c-0.469-0.469-0.469-1.229,0-1.697l2.758-3.15L5.651,6.849c-0.469-0.469-0.469-1.228,0-1.697s1.228-0.469,1.697,0L10,8.183
                                           l2.651-3.031c0.469-0.469,1.228-0.469,1.697,0s0.469,1.229,0,1.697l-2.758,3.152l2.758,3.15
                                           C14.817,13.62,14.817,14.38,14.348,14.849z" />
                                            </svg>

                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div x-show="selected.length    == 0" class="flex-1">
                                <input placeholder="{{ $attributes['placeholder'] }}"
                                    class="bg-transparent p-1 px-2 appearance-none outline-none h-full w-full text-gray-800"
                                    x-bind:value="selectedValues()" style="padding:0.5rem 0.2rem 0.6rem 1.2rem"
                                >
                            </div>
                        </div>
                        <div class="text-gray-300 w-8 py-1 pl-2 pr-1 flex items-center border-gray-200 svelte-1l8159u">

                            <button type="button" x-show="isOpen() === true" x-on:click="open"
                                class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                <svg version="1.1" class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </button>
                            <button type="button" x-show="isOpen() === false" @click="close"
                                class="cursor-pointer w-6 h-6 text-gray-600 outline-none focus:outline-none">
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="w-full">
                    <div x-show.transition.origin.top="isOpen()"
                        class="absolute rounded-md ring-1 ring-black ring-opacity-20 py-1 top-100 bg-white z-40 w-full lef-0 max-h-select overflow-y-auto svelte-5uyqqj"
                        x-on:click.away="close">
                        <div class="flex flex-col w-full">
                            <template x-for="(option,index) in options" :key="option">
                                <div>
                                    <div class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-teal-100"
                                        @click="select(index,$event)">
                                        <div x-bind:class="option.selected ? 'border-teal-600' : ''"
                                            class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 relative">
                                            <div class="w-full items-center flex">
                                                <div class="mx-2 leading-6" x-model="option" x-text="option.text"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
			</form>
        </div>
        <script>
            var id = "{{ $attributes['id'] }}";

            var dropdown = function () {
                return {
                    options: [],
                    selected: [],
                    show: false,
                    open() { this.show = true },
                    close() { this.show = false },
                    isOpen() { return this.show === true },
                    select(index, event) {
                        if (!this.options[index].selected) {

                            this.options[index].selected = true;
                            this.options[index].element = event.target;
                            this.selected.push(index);

                        } else {
                            this.selected.splice(this.selected.lastIndexOf(index), 1);
                            this.options[index].selected = false
                        }
                    },
                    remove(index, option) {
                        this.options[option].selected = false;
                        this.selected.splice(index, 1);


                    },
                    loadOptions() {
                        const options = document.getElementById(id).options;
                        for (let i = 0; i < options.length; i++) {
                            this.options.push({
                                value: options[i].value,
                                text: options[i].innerText,
                                selected: options[i].getAttribute('selected') != null ? options[i].getAttribute('selected') : false
                            });
                        }


                    },
                    selectedValues(){
                        return this.selected.map((option)=>{
                            return this.options[option].value;
                        })
                    }
                }
                }

                document.getElementById("{{ $attributes['id'] }}_values").addEventListener("change", function(event) {
                    //console.log(this.value.split(","));
                    console.log(dropdown.options);
                });
        </script>
  </div>
