/*
 * This is the initial API interface
 * we set the csrf off for the api call
 */

import axios from "axios";

export const client = axios.create({
    withCredentials: false, // required to get response from HereMaps server
});
