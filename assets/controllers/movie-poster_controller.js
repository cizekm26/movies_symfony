import { Controller } from '@hotwired/stimulus';
import axios from 'axios';

export default class extends Controller {
    show(event) {
        event.preventDefault();
    }
}
