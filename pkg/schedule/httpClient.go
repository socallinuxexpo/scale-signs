package schedule

import (
	"io"
	"log"
	"net"
	"net/http"
	"time"
)

func newHTTPclient() *http.Client {

	var netTransport = &http.Transport{
		Dial: (&net.Dialer{
			Timeout: 5 * time.Second,
		}).Dial,
		TLSHandshakeTimeout: 5 * time.Second,
	}

	var httpClient = &http.Client{
		Timeout:   time.Second * 10,
		Transport: netTransport,
	}

	return httpClient
}

func fetch(url string) ([]byte, error) {
	c := newHTTPclient()
	resp, err := c.Get(url)
	if err != nil {
		return nil, err
	}
	defer func() {
		err = resp.Body.Close()
		if err != nil {
			log.Printf("unable to close response body %v", err)
		}
	}()
	body, err := io.ReadAll(resp.Body)
	if err != nil {
		return nil, err
	}
	return body, nil
}
