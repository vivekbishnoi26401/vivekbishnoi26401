<template>
    <div class="text-white mb-8">
        <div class="places-input">
                    <input
            type="text"
            v-model="searchQuery"
            @input="fetchPlaces(searchQuery)"
            placeholder="Search for a place..."
            class=" border w-full p-2  text-black"
        />

        <ul v-if="places.length" class="text-black bg-white">
            <li
                v-for="(place, index) in places"
                :key="index"
                @click="selectPlace(place)"
                class="cursor-pointer p-2 border-b"
            >
                {{ place.properties.formatted }}
            </li>
        </ul>
        </div>
        <div class="weather-container font-sans rounded-lg w-128  p-128 overflow-hidden bg-gray-900 shadow-lg mt-4">
            <div class="current-weather flex item-center justify-between px-6 py-8 ">
                <div class="flex items-center">
                    <div>
                        <div class="text-5xl font-semibold">{{ currentTemperature.actual }} °C</div>
                        <div>Feels like {{currentTemperature.feels}}°</div>
                    </div>
                    <div class="mx-5">
                        <div class="font-semibold">{{currentTemperature.summary}} </div>
                        <div>{{location.name}}</div>
                    </div>
                </div>
                <div><img :src="currentTemperature.icon" alt="Weather Icon"></div>
            </div>
            <div  v-if="daily.length" class="future-weather text-sm bg-gray-800 px-6 py-8 overflow-hidden">
                <div v-for="(day, index) in daily" :key="index" class="flex items-center">
                    <div class="w-1/6 text-lg text-gray-200 mt-5">
                        {{ new Date(day.valid_date).toLocaleDateString('en-US', { weekday: 'short' }) }}
                    </div>
                    <div class="w-4/6 px-4 flex items-center">
                        <img :src="`https://www.weatherbit.io/static/img/icons/${day.weather.icon}.png`" alt="Weather Icon" class="w-8 h-8">
                        <div class="ml-3">{{ day.weather.description }}</div>
                    </div>
                    <div class="w-1/6 text-right">
                        <div>{{ Math.round(day.max_temp) }}°C</div>
                        <div>{{ Math.round(day.min_temp) }}°C</div>
                    </div>
                </div>
                
                
            </div>

        </div>
    </div> 
</template>

<script>
//     export default {
//     data() {
//         return {
//             currentTemperature:{
//                 actual:'',
//                 feels:'',
//                 summary:'',
//                 icon:''
//             },
//             daily:[],
//             location: {
//                 name: 'Jodhpur,Rajasthan',
//                 lat: 26.2389,
//                 lng: 73.0243,
//             }
//         };
//     },
//     mounted() {
//         this.fetchData();
//     },
//     methods: {
//         fetchPlaces(query) {
//             const apiKey = 'YOUR_GEOAPIFY_API_KEY'; // Replace with your Geoapify API key
//             fetch(`https://api.geoapify.com/v1/geocode/search?text=${query}&apiKey=${apiKey}`)
//             .then(response => response.json())
//             .then(data => {
//             console.log(data);
//                 // Assuming you want to store the results in a places array
//                 this.places = data.features; // Store the search results
//             })
//             .catch(error => {
//                 console.error('Error fetching places data:', error);
//             });
//         },
//         fetchData() {
//             fetch(`/api/weather?lat=${this.location.lat}&lng=${this.location.lng}`)
//                 .then(response => response.json())
//                 .then(data => {
//                     console.log(data);
//                     console.log(data.data[0].weather.icon);
//                     this.currentTemperature.actual = Math.round(data.data[0].temp)
//                     this.currentTemperature.feels = Math.round(data.data[0].app_min_temp)
//                     this.currentTemperature.summary = data.data[0].weather.description
//                     //this.currentTemperature.icon = data.data[0].weather.icon
//                     this.currentTemperature.icon = `https://www.weatherbit.io/static/img/icons/${data.data[0].weather.icon}.png`;
//                     this.daily = data.data
//                     // console.log("daily",data.data);
//                 })
//                 .catch(error => {
//                     console.error('Error fetching weather data:', error);
//                 });
//         }
//     },
//         created() {
//         this.fetchData();
//     }
// };
export default {
    data() {
        return {
            currentTemperature: {
                actual: '',
                feels: '',
                summary: '',
                icon: ''
            },
            daily: [],
            location: {
                name: 'Jodhpur, Rajasthan',
                lat: 26.2389,
                lng: 73.0243,
            },
            places: [], // Store search results
            searchQuery: '' // Store the search query
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchPlaces(query) {
            const apiKey = '7a3f3970e7b84365b1721cde687696d3'; // Replace with your Geoapify API key
            fetch(`https://api.geoapify.com/v1/geocode/search?text=${query}&apiKey=${apiKey}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    this.places = data.features; // Store the search results
                })
                .catch(error => {
                    console.error('Error fetching places data:', error);
                });
        },
        fetchData() {
            fetch(`/api/weather?lat=${this.location.lat}&lng=${this.location.lng}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    this.currentTemperature.actual = Math.round(data.data[0].temp);
                    this.currentTemperature.feels = Math.round(data.data[0].app_min_temp);
                    this.currentTemperature.summary = data.data[0].weather.description;
                    this.currentTemperature.icon = `https://www.weatherbit.io/static/img/icons/${data.data[0].weather.icon}.png`;
                    this.daily = data.data; // Store daily forecast
                })
                .catch(error => {
                    console.error('Error fetching weather data:', error);
                });
        },
        selectPlace(place) {
            // Update the location based on the selected place
            this.location.lat = place.geometry.coordinates[1];
            this.location.lng = place.geometry.coordinates[0];
            this.location.name = place.properties.formatted;
            this.places = [];
        // this.searchQuery = '';
            // Fetch the weather data for the selected place
            this.fetchData();
        }
    }
};

</script>
