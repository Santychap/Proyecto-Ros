package com.Ros.exe.Config;

import org.springframework.context.annotation.Configuration;
import org.springframework.format.FormatterRegistry;
import org.springframework.web.servlet.config.annotation.ResourceHandlerRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurer;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import org.springframework.core.convert.converter.Converter;

@Configuration
public class WebConfig implements WebMvcConfigurer {

    @Override
    public void addFormatters(FormatterRegistry registry) {
        registry.addConverter(new StringToDateConverter());
    }

    @Override
    public void addResourceHandlers(ResourceHandlerRegistry registry) {
        registry.addResourceHandler("/images/**")
                .addResourceLocations("classpath:/static/images/");
    }

    public static class StringToDateConverter implements Converter<String, Date> {
        private final SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");

        @Override
        public Date convert(String source) {
            try {
                return dateFormat.parse(source);
            } catch (ParseException e) {
                throw new IllegalArgumentException("Invalid date format: " + source);
            }
        }
    }
}