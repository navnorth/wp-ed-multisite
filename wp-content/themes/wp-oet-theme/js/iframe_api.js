((document, window) => {
  window.App = window.App || {};
  let tag = null;
  let YT = null;
  const html = document.querySelector('html');
  App.YT = function (callback) {
    if (!tag) {
      tag = document.createElement('script');
      tag.src = "https://www.youtube.com/iframe_api";
      document.querySelector('head').append(tag);
      window.YTConfig = {};
      window.YT = {};
      window.onYouTubeIframeAPIReady = () => {
        YT = window.YT;
        html.dispatchEvent(new CustomEvent('YouTubeIframeAPIReady'));
        delete window.YT;
        delete window.YTConfig;
        delete window.onYouTubeIframeAPIReady;
      }
    }
    if (YT) {
      callback(YT);
    }
    else {
      html.addEventListener('YouTubeIframeAPIReady', e => callback(YT));
    }
  };
})(document, window);