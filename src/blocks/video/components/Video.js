import { useState, useEffect } from "react";

const Video = ({data, setAttributes}) => {

  const getVideoProvider = (url) => {
    if (!url) return null;
    if (url.includes("youtube.com") || url.includes("youtu.be")) return "youtube";
    if (url.includes("vimeo.com")) return "vimeo";
    if (url.includes("facebook.com")) return "facebook";
    return null;
  };

  const getThumbnail = (url, provider) => {
    if (provider === "youtube") {
      const videoId = url.split("v=")[1]?.split("&")[0] || url.split("youtu.be/")[1]?.split("?")[0];
      return `https://i.ytimg.com/vi/${videoId}/maxresdefault.jpg`;
    }
    if (provider === "vimeo") {
      return `https://vumbnail.com/${url.split("vimeo.com/")[1]}_large.jpg`;
    }
    return "";
  };

  const [thumbnail, setThumbnail] = useState("");
  const videoProvider = getVideoProvider(data.video_url);

  useEffect(() => {
    if (videoProvider === "youtube") {
      const videoId = data.video_url.split("v=")[1]?.split("&")[0] || data.video_url.split("youtu.be/")[1]?.split("?")[0];
      const maxResUrl = `https://i.ytimg.com/vi/${videoId}/maxresdefault.jpg`;
      const fallbackUrl = `https://i.ytimg.com/vi/${videoId}/hqdefault.jpg`;

      // Check if maxresdefault exists, otherwise fallback to hqdefault
      fetch(maxResUrl).then((res) => {
        if (res.ok) {
          setThumbnail(maxResUrl);
        } else {
          setThumbnail(fallbackUrl);
        }
      }).catch(() => {
        setThumbnail(fallbackUrl);
      });
    } else {
      setThumbnail(getThumbnail(data.video_url, videoProvider));
    }
    setAttributes({ video_provider: videoProvider });
  }, [data.video_url, videoProvider]);

  return (
  <div class="vidpress">
    {
      thumbnail && <>
        <img class="vidpress__thumbnail" src={thumbnail} alt="Video Thumbnail"/>
        <div class="vidpress__controls">
          <div class="vidpress__controls-group">
            <button class="vidpress__controls-btn">
              <span class="dashicons dashicons-controls-back"></span>
            </button>
            <button class="vidpress__controls-btn vidpress__controls-btn--play">
              <span class="dashicons dashicons-controls-play"></span>
            </button>
            <button class="vidpress__controls-btn">
              <span class="dashicons dashicons-controls-forward"></span>
            </button>
          </div>

          <div class="vidpress__progress">
            <input type="range" class="vidpress__progress-bar" value="0" min="0" max="100" step="0.1"/>
          </div>

          <div class="vidpress__volume">
            <button class="vidpress__controls-btn" id="muteButton">
              <span class="dashicons dashicons-controls-volumeon"></span>
            </button>
            <input type="range" class="vidpress__volume-slider" value="80" min="0" max="100" step="1"/>
          </div>
        </div>
      </>
    }
    {
      videoProvider != 'youtube' && videoProvider != 'vimeo' && <div class="vidpress__error">Unsupported video URL</div>
    }
  </div>
  );
};

export default Video;
