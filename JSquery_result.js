// I do not see a reason to use the class FilteredSorter for filter and sort items
// For me, it is better to use just function like
// filterAndSort(items, asc = true, ofType = 'number') { ... }
// Also, for search a top score country we do not need to sort or filter item,
// just search Min or Max in an array

class FilteredSorter {

    // The method filter is not readable enough,
    // Also, it looks like method has a bug,
    // because there is no i-- on splice
    // Also, it is no good to do splice, because complexity is O(n^2),
    // (shift all elements after splice)
    // It looks like, in this case, the method should be private

    //filter() {
    //    for (var i = 0; i < this.items.length; i++) {
    //        if (typeof this.items[i] === this.ofType) {
    //            const a = this.items.splice(i - 1, 1);
    //        }
    //    }
    //}

    static filter(items, ofType) {
        // Now, complexity is O(n)
        return items.filter((item) => {
            return typeof(item) !== ofType;
        });
    }

    //sort() {
    //    this.items.sort((a, b) => this.asc ? a - b : b - a)
    //}

    static sort(items, asc = true) {
        // I do not like checking the order for each compare operation,
        // It is better to user something like that
        // Also, I'd like get items and order like arguments
        if (asc) {
            items.sort((a, b) => a - b);
        } else {
            items.sort((a, b) => b - a);
        }
    }

    // Do not need to use aliases with the same name
    //constructor({items: items = [], ofType: ofType = 'number', asc: asc = true} = {}) {
    constructor({items = [], ofType = 'number', asc = true} = {}) {
        this.items = items;
        this.ofType = ofType;
        this.filter();
        this.asc = asc;
        this.sort();
    }
}

function displayTop(items) {
    const filteredSorter = new FilteredSorter({
        items: items.slice(),
        asc: false
    });

    // it is really bad to use properties of the Instances directly
    // I prefer to use properties of Instances like protected.
    // Therefore, it is better to use filteredSorter.getItems()
    // Also, items[0] can be undefined here, and skipped ';' for some lines
    const topRating = filteredSorter.items[0]

    // If we want to find just 1 top element,
    // We should use another function, without filter and sort
    // It is easier to find Max or Min and return position of element.
    const topRatingIndex = items.indexOf(topRating)
    const topLocation = items[topRatingIndex - 1]

    // Yep, it is fine, but lets check that element found, before innerHTML
    // Also, it is better to cache found element to avoid call getElementById
    // every time, when I need to update element
    document.getElementById('location').innerHTML = topLocation;
    document.getElementById('rating').innerHTML = topRating;
}


// ----------------------------------------------------------------------------
const items = ['Singapore', 54, 'Costa Rica', 56, 'Sri Lanka', 44, 'Ecuador', 48]

// Oh, no... I sure, it is not so good decision to use data structure like above,
// please, see my solutions below

// MY SOLUTION

// the function if you really want to use only data structure like above
function getTopCountry(items) {
    if (!Array.isArray(items)) {
        // or throw new Error();
        return null;
    }
    let max = 0;
    let country;
    // Complexity is O(n)
    for (let i = 1; i < items.length; i += 2) {
        let score = items[i];
        if (score > max) {
            max = score;
            country = items[i - 1];
        }
    }

    return [country, max];
}

console.log(getTopCountry(items));


// OPTION 2


// Use another structure
const items2 = {'Singapore': 54, 'Costa Rica': 56, 'Sri Lanka': 44, 'Ecuador': 48};

// and now, we can easy find top country
function getTopCountry2(items) {
    if (!items || (typeof(items) !== 'object')) {
        return null;
    }
    let max = 0;
    let country;
    // Complexity is O(n)
    for (let key in items) {
        if (!items.hasOwnProperty(key)) {
            continue;
        }
        if (items[key] > max) {
            max = items[key];
            country = key;
        }
    }

    return [country, max];
}

console.log(getTopCountry2(items2));


// OPTION 3


// Use another one structure for data
const items3 = [
    {country: 'Singapore', score: 54},
    {country: 'Costa Rica', score: 56},
    {country: 'Sri Lanka', score: 44},
    {country: 'Ecuador', score: 48},
];

// and now, use can easy find top
function getTopCountry3(items) {
    if (!Array.isArray(items) || !items.length) {
        return null;
    }
    if (items.length === 1) {
        return items[0];
    }

    // Complexity is O(n)
    return items.reduce(
        (prev, curr) => {
            if (!prev) {
                return curr;
            }
            return prev.score > curr.score ? prev : curr;
        },
        {}
    );
}

console.log(getTopCountry3(items3));









// ORIGINAL CODE

/*
// Please tell us what do you like and what do you dislike in the code below:

class FilteredSorter {
    filter() {
        for (var i = 0; i < this.items.length; i++) {
            if (typeof this.items[i] === this.ofType) {
                const a = this.items.splice(i - 1, 1);
            }
        }
    }

    sort() {
        this.items.sort((a, b) => this.asc ? a - b : b - a)
    }

    constructor({
        items: items = [],
        ofType: ofType = 'number', asc: asc = true,
        } = {}) {
        this.items = items;
        this.ofType = ofType;
        this.filter();
        this.asc = asc;
        this.sort();
    }
}

function displayTop(items) {
    const filteredSorter = new FilteredSorter({
        items: items.slice(),
        asc: false
    });
    const topRating = filteredSorter.items[0]
    const topRatingIndex = items.indexOf(topRating)
    const topLocation = items[topRatingIndex - 1]
    document.getElementById('location').innerHTML = topLocation;
    document.getElementById('rating').innerHTML = topRating;
}
// ----------------------------------------------------------------------------
//We have a list of items, which follows the pattern <'Location Name', 'Rating'>, <'Location Name', 'Rating'> ...
const items = ['Singapore', 54, 'Costa Rica', 56, 'Sri Lanka', 44, 'Ecuador', 48]
//We want to get the top rated location and its rating displayTop(items);
 */
