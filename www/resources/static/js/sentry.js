import * as Sentry from '@sentry/browser';

let instance = null;

/**
 * https://docs.sentry.io/error-reporting/capturing/?platform=javascript
 */
export class SentryInstance {

    constructor() {
        if (instance === null) {
            this.dsn = 'https://5bd44950a6124647821741fd9bd53880@o310314.ingest.sentry.io/5454765';
            this.production = process.env.NODE_ENV === 'production';
            if (this.production) {
                const denyUrls = [
                    // РСЯ
                    /an\.yandex\.ru/i,
                    // Chrome extensions
                    /extensions\//i,
                    /^chrome:\/\//i,
                ];
                const ignoreErrors = [
                    'Loading chunk',
                ];
                Sentry.init({
                    dsn: this.dsn,
                    // ignoreErrors,
                    denyUrls,
                    beforeSend(event, hint) {
                        const error = hint.originalException;
                        if (error && error.message && ignoreErrors.includes(error.message)) {
                            return null;
                        }

                        return event;
                    },
                });
            }
            this.tracesSampleRate = 1.0;
            instance = this;
        }
        return instance;
    }

    captureMessage(messageStr) {
        if (this.production) {
            Sentry.captureMessage(messageStr);
        }
    }

    captureException(exception, contextObject) {
        if (this.production) {
            Sentry.captureException(exception, contextObject);
        }
    }

}
