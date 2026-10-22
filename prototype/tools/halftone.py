"""BRG-81: redraw the provisional booth photo as a halftone of trail dots (DIRECTION.md §6).

Every dot comes from a source pixel; nothing is generated. Rerun when the photo changes:
  python tools/halftone.py            (needs Pillow; not a project dependency, use a throwaway venv)
Writes src/assets/photo/cabina-halftone-{800,1600}.png, amber dots on a transparent ground (for Tinta).
"""
from pathlib import Path

from PIL import Image, ImageDraw, ImageOps

ROOT = Path(__file__).resolve().parent.parent / "src/assets/photo"
SOURCE = ROOT / "cabina-1600.webp"
CROP = (0, 250, 1600, 1150)  # the band with the interpreters and microphones
PITCH = 8  # px between dot centres at 1600 wide
SCALE = 4  # render oversampled, then downsample for round edges
AMBER = (0xE3, 0xA1, 0x48, 255)  # Rastro, the trail on Tinta


def halftone(width: int) -> Image.Image:
    tone = ImageOps.equalize(ImageOps.grayscale(Image.open(SOURCE).crop(CROP)))
    w, h = tone.size
    canvas = Image.new("RGBA", (w * SCALE, h * SCALE), (0, 0, 0, 0))
    draw = ImageDraw.Draw(canvas)
    for y in range(PITCH // 2, h, PITCH):
        for x in range(PITCH // 2, w, PITCH):
            radius = (tone.getpixel((x, y)) / 255) ** 0.6 * PITCH / 2 * SCALE
            if radius >= SCALE * 0.5:
                cx, cy = x * SCALE, y * SCALE
                draw.ellipse((cx - radius, cy - radius, cx + radius, cy + radius), fill=AMBER)
    # one colour, varying alpha: a 16-entry palette keeps the edges and cuts the file size
    return canvas.resize((width, round(h * width / w)), Image.LANCZOS).quantize(16, method=Image.Quantize.FASTOCTREE)


if __name__ == "__main__":
    for width in (800, 1600):
        out = ROOT / f"cabina-halftone-{width}.png"
        image = halftone(width)
        image.save(out, optimize=True)
        assert image.size[0] == width and image.getbbox(), out  # self-check: right size, not empty
        print(out.name, image.size, out.stat().st_size // 1024, "KB")
