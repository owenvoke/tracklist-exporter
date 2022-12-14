FROM php:8.2-cli-alpine

RUN $(php -r '$extensionInstalled = array_map("strtolower", \get_loaded_extensions(false));$requiredExtensions = ["zlib"];$extensionsToInstall = array_diff($requiredExtensions, $extensionInstalled);if ([] !== $extensionsToInstall) {echo \sprintf("docker-php-ext-install %s", implode(" ", $extensionsToInstall));}echo "echo \"No extensions\"";')

COPY builds/tracklist-exporter /tracklist-exporter

ENTRYPOINT ["/tracklist-exporter"]
