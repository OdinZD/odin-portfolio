# Deploying to cPanel (GUI only, primary domain, MySQL)

This app is built locally; the server only serves files. The Laravel app stays in
its Git clone folder (outside `public_html`), and a `.cpanel.yml` deploy hook copies
the prebuilt `public/` into `public_html` and runs migrations.

## One-time setup in cPanel

1. **PHP version** — *MultiPHP Manager* → set the domain to **PHP 8.3** (or 8.4).
2. **Create the database** — *MySQL Databases*:
   - Create a database (e.g. `portfolio`) → real name becomes `cpuser_portfolio`.
   - Create a user + password → real name `cpuser_dbadmin`.
   - **Add the user to the database** with **ALL PRIVILEGES**.
   - Note the three values for `.env`.
3. **Repository** — *Git Version Control*:
   - Make sure the repo is cloned to a folder **outside** `public_html`
     (e.g. `/home/cpuser/repositories/odin-portfolio`). If it's inside `public_html`,
     remove it and re-create it outside.
   - Deployed branch = **main**.

## Deploy

4. *Git Version Control* → **Update from Remote** (pulls this repo), then
   **Deploy HEAD Commit**. The first deploy copies files into `public_html`;
   migrations are skipped because `.env` doesn't exist yet (that's expected).
5. **Create `.env`** — *File Manager* → open the app's clone folder → enable
   "Show Hidden Files" → copy `.env.production.example` to `.env` → edit it:
   - `APP_URL=https://your-domain`
   - the `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` from step 2
   - leave `APP_KEY=` blank (generated on next deploy)
6. **Deploy HEAD Commit** again. This time it generates `APP_KEY`, runs
   `migrate --seed`, and caches config/routes/views.
7. **SSL** — *SSL/TLS Status* → Run AutoSSL so the site is HTTPS.
8. Visit your domain. 🎉

## Updating later

Locally: `npm run build` (rebuilds `public/build`) → commit → push. Then in cPanel:
**Update from Remote** → **Deploy HEAD Commit**.

## Notes / troubleshooting

- **`public_html` shows a default page**, not the site → delete any leftover
  `index.html` in `public_html` (the deploy tries to, but check).
- **500 error / "vendor/autoload.php not found"** → the host has no Composer in the
  deploy shell. Fix: locally run `composer install --no-dev --optimize-autoloader`,
  temporarily un-ignore `/vendor` in `.gitignore`, commit & push `vendor/`, redeploy.
- **PHP version error during deploy** → the deploy-hook `php` differs from the web
  PHP; set MultiPHP to 8.3 and/or ask the host which `php` the hook uses.
- **Read contact messages** → cPanel *phpMyAdmin* → `contact_messages` table.
