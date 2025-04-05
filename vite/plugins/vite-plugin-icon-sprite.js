import { promises as fs } from "fs";
import path from "path";

export default function IconSpritePlugin(iconsSrc, spriteDest, spriteName) {
  async function generateIconSprite() {
    // Read the SVG files in the static/icons folder
    const iconsDir = path.join(process.cwd(), iconsSrc);
    const files = await fs.readdir(iconsDir);
    let symbols = "";

    // Build up the SVG sprite from the SVG files
    for (const file of files) {
      if (!file.endsWith(".svg")) continue;
      let svgContent = await fs.readFile(path.join(iconsDir, file), "utf8");
      const id = file.replace(".svg", "");
      // Extract viewBox using regex
      const viewBoxMatch = svgContent.match(/viewBox="([^"]+)"/);
      const viewBox = viewBoxMatch ? `viewBox="${viewBoxMatch[1]}"` : "";
      // Create the symbol element with only id and viewBox attributes
      const symbol = `<symbol id="${id}" ${viewBox} xmlns="http://www.w3.org/2000/svg">${svgContent.replace(
        /<svg[^>]*>|<\/svg>/g,
        ""
      )}</symbol>`;

      symbols += symbol + "\n";
    }

    // Write the SVG sprite to a file in the static folder
    const sprite = `<svg width="0" height="0" style="display: none">\n\n${symbols}</svg>`;
    const spritePath = path.join(process.cwd(), spriteDest, spriteName);

    // Create new sprite
    await fs.writeFile(spritePath, sprite);
  }

  async function handleIconUpdate(filePath) {
    if (filePath.endsWith(".svg")) {
      await generateIconSprite();
    }
  }

  return {
    name: "icon-sprite-plugin",
    buildStart() {
      return generateIconSprite();
    },
    configureServer(server) {
      const iconsPath = path.join(process.cwd(), iconsSrc, "*.svg");

      // Watch for new, changed, or deleted SVG files
      server.watcher.add(iconsPath);
      server.watcher.on("all", handleIconUpdate);
      server.watcher.on("change", handleIconUpdate);
      server.watcher.on("unlink", handleIconUpdate);
    },
  };
}
