"""BRG-81: redraw the provisional booth photo as a halftone of trail dots (DIRECTION.md §6).

Every dot comes from a source pixel; nothing is generated. Rerun when the photo changes:
  python tools/halftone.py            (needs Pillow; not a project dependency, use a throwaway venv)
Writes src/assets/photo/cabina-halftone-{800,1600}.png, amber dots on a transparent ground (for Tinta).

BRG-84: python tools/halftone.py --poster <frame.jpg> writes video-poster-{800,1600}.png from the
institutional video's frame (https://i.ytimg.com/vi/himqflZxhNs/maxresdefault.jpg, Bridge's own video):
the presenter only, left of the old logo and above the subtitle band; the near-white studio wall gets no dots.
"""
import sys
from pathlib import Path

from PIL import Image, ImageDraw, ImageOps

ROOT = Path(__file__).resolve().parent.parent / "src/assets/photo"
SOURCE = ROOT / "cabina-1600.webp"
CROP = (0, 250, 1600, 1150)  # the band with the interpreters and microphones
PITCH = 8  # px between dot centres at 1600 wide
SCALE = 4  # render oversampled, then downsample for round edges
AMBER = (0xE3, 0xA1, 0x48, 255)  # Rastro, the trail on Tinta


POSTER_CROP = (40, 70, 600, 575)  # presenter in the 1280x720 frame
WALL = 222  # source grey at or above this is the studio wall: no dot
POSTER_PITCH = 4  # the crop is small; a finer grid keeps the face legible


def halftone(width: int, source: Path = SOURCE, crop=CROP, wall: int = 256, pitch: int = PITCH) -> Image.Image:
    grey = ImageOps.grayscale(Image.open(source).crop(crop))
    tone = ImageOps.equalize(grey)
    w, h = tone.size
    canvas = Image.new("RGBA", (w * SCALE, h * SCALE), (0, 0, 0, 0))
    draw = ImageDraw.Draw(canvas)
    for y in range(pitch // 2, h, pitch):
        for x in range(pitch // 2, w, pitch):
            if grey.getpixel((x, y)) >= wall:
                continue
            radius = (tone.getpixel((x, y)) / 255) ** 0.6 * pitch / 2 * SCALE
            if radius >= SCALE * 0.5:
                cx, cy = x * SCALE, y * SCALE
                draw.ellipse((cx - radius, cy - radius, cx + radius, cy + radius), fill=AMBER)
    # one colour, varying alpha: a 16-entry palette keeps the edges and cuts the file size
    return canvas.resize((width, round(h * width / w)), Image.LANCZOS).quantize(16, method=Image.Quantize.FASTOCTREE)


if __name__ == "__main__":
    if sys.argv[1:2] == ["--poster"]:
        frame = Path(sys.argv[2])
        for width in (800, 1600):
            out = ROOT / f"video-poster-{width}.png"
            # the crop is 560 px wide, so the 1600 output is upsampled dots, still one dot per source cell
            image = halftone(width, frame, POSTER_CROP, WALL, POSTER_PITCH)
            image.save(out, optimize=True)
            assert image.size[0] == width and image.getbbox(), out
            print(out.name, image.size, out.stat().st_size // 1024, "KB")
        sys.exit()
    if sys.argv[1:2] == ["--tile"]:
        # BRG-84 hero tiles: python tools/halftone.py --tile <photo> <name> <x0> <y0> <x1> <y1>
        # writes tile-<name>-600.png; the page uses it as a CSS mask, so the dot colour follows the tile's --trail
        photo, name = Path(sys.argv[2]), sys.argv[3]
        crop = tuple(int(v) for v in sys.argv[4:8])
        out = ROOT / f"tile-{name}-600.png"
        image = halftone(600, photo, crop, pitch=max(4, (crop[2] - crop[0]) // 150))  # ~150 dots across, as fine as the booth halftone
        image.save(out, optimize=True)
        assert image.size[0] == 600 and image.getbbox(), out
        print(out.name, image.size, out.stat().st_size // 1024, "KB")
        sys.exit()
    for width in (800, 1600):
        out = ROOT / f"cabina-halftone-{width}.png"
        image = halftone(width)
        image.save(out, optimize=True)
        assert image.size[0] == width and image.getbbox(), out  # self-check: right size, not empty
        print(out.name, image.size, out.stat().st_size // 1024, "KB")
