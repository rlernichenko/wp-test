class Rating {
	constructor(elem) {
		this.elem = document.querySelector(elem);

		this.classes = {
			starRating: 'star-rating',
			countRating: 'count-rating',
		}

		this.init();
	}

	init() {
		this.attachEvents();
	}

	attachEvents() {
		//todo localize script and get ajaxUrl from php

		document.addEventListener('click', (e) => {
			let clickedItem = e.target;
			if( e.target.nodeName === 'path' ) clickedItem = e.target.parentNode;

			const totalStars = 5;
			const clickedId = clickedItem.dataset.rating;
			const revertedId = totalStars - clickedId + 1;

			const starsWrapper = clickedItem.parentNode;
			const postId = starsWrapper.dataset.id;

			if( typeof postId !== 'undefined' && starsWrapper.classList.contains(this.classes.starRating) &&
				!isNaN(revertedId) ) {
				this.sendRequest(revertedId, postId, starsWrapper);
			}

		});
	}

	sendRequest(rating, postID, starsWrapper) {
		console.log('-sendRequest-')
		const xhr = new XMLHttpRequest();
		xhr.open('POST', '/wp-admin/admin-ajax.php', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = () => {
			if (xhr.status >= 200 && xhr.status < 300) {
				try {
					const responseObj = JSON.parse(xhr.responseText);
					if( typeof responseObj.data.average_rating === 'number' ) {
						this.fillCountRating(starsWrapper, responseObj.data.average_rating);
					}

				} catch (e) {
					console.error('Error parsing JSON:', e);
				}
			}else {
				console.error('Request failed with status:', xhr.status);
			}
		};
		xhr.send('action=rate_book&rating=' + rating + '&post_id=' + postID);
	}

	fillCountRating(starsWrapper, newRating) {
		const globalRatingWrapper = starsWrapper.parentNode;
		const countRatingElem = globalRatingWrapper.querySelector(`.${this.classes.countRating}`);

		if( typeof countRatingElem !== 'undefined' ) {
			countRatingElem.innerHTML = newRating;
		}
	}
}


if( window.components === undefined || window.components === 'undefined' ) window.components = {};
window.components.rating = new Rating();
